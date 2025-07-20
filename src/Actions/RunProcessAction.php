<?php

namespace Yuges\Processable\Actions;

use Throwable;
use Illuminate\Bus\Batch;
use Yuges\Processable\Models\Stage;
use Illuminate\Support\Facades\Bus;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Enums\ProcessStatesEnum;

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
            $model->stages->map(function (Stage $stage) {
                return Config::getProcessStageJob($stage);
            })
        )->before(function (Batch $batch) {

        })->progress(function (Batch $batch) use ($model) {

        })->catch(function (Batch $batch, Throwable $e) {

        })->finally(function (Batch $batch) use ($model) {
            $model->update([
                'state' => ProcessStatesEnum::COMPLETED,
            ]);
        })->dispatch();

        return $model;
    }
}
