<?php

namespace Yuges\Processable\Actions;

use Exception;
use Throwable;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Bus;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Enums\ProcessState;
use Yuges\Processable\Jobs\ProcessStageJob;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Interfaces\Stage as InterfacesStage;

class RunProcessAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    public static function create(Processable $processable): self
    {
        return new static($processable);
    }

    public function execute(Process $model): Process
    {
        $process = new $model->class;

        $jobs = Collection::make($process->stages())->map(function (string $stage) use ($model) {
            $stage = new $stage;

            if (! $stage instanceof InterfacesStage) {
                throw new Exception('Error stage type');
            }

            $stage = $model->stages->firstOrFail('class', '=', $stage::class);

            return Config::getProcessStageJob(
                $stage,
                $model,
                $this->processable,
                ProcessStageJob::class
            );
        });

        $action = Config::getUpdateProcessAction($model, UpdateProcessAction::class);

        Bus::batch([$jobs->toArray()])
        ->before(function (Batch $batch) use ($action) {
            $action->execute(ProcessState::Started, $batch);
        })
        ->progress(function (Batch $batch) use ($action) {
            $action->execute(ProcessState::Processing, $batch);
        })
        ->catch(function (Batch $batch, Throwable $e) use ($action) {
            $action->execute(ProcessState::Failed, $batch, $e);
        })
        ->finally(function (Batch $batch) use ($action) {
            $action->execute(ProcessState::Finished, $batch);
        })
        ->onConnection(Config::getQueueConnection())
        ->onQueue(Config::getQueueName())
        ->dispatch();

        return $model;
    }
}
