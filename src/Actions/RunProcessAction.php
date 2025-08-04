<?php

namespace Yuges\Processable\Actions;

use Exception;
use Throwable;
use Illuminate\Bus\Batch;
use Illuminate\Support\Collection;
use Yuges\Processable\Models\Stage;
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

            $stage = $model->stages->firstWhere('class', '=', $stage::class);

            if (! $stage instanceof Stage) {
                throw new Exception('Error stage type');
            }

            return Config::getProcessStageJob(
                $stage,
                $model,
                $this->processable,
                ProcessStageJob::class
            );
        });

        Bus::batch([$jobs->toArray()])->before(function (Batch $batch) use ($model) {
            $model->update([
                'batch_id' => $batch->id,
                'state' => ProcessState::Started,
            ]);
        })->progress(function (Batch $batch) use ($model) {

        })->catch(function (Batch $batch, Throwable $e) {

        })->finally(function (Batch $batch) use ($model) {
            $model->update([
                'state' => ProcessState::Finished,
            ]);
        })
        ->onConnection(Config::getQueueConnection())
        ->onQueue(Config::getQueueName())
        ->dispatch();

        return $model;
    }
}
