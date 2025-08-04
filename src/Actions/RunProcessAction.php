<?php

namespace Yuges\Processable\Actions;

use Throwable;
use Illuminate\Bus\Batch;
use Yuges\Processable\Models\Stage;
use Illuminate\Support\Facades\Bus;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Enums\ProcessState;
use Yuges\Processable\Jobs\ProcessStageJob;
use Yuges\Processable\Interfaces\Processable;

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
        Bus::batch(
            $model->stages->map(function (Stage $stage) use ($model) {
                return Config::getProcessStageJob($stage, $model, $this->processable, ProcessStageJob::class);
            })
        )->before(function (Batch $batch) use ($model) {
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
        })->dispatch();

        return $model;
    }
}
