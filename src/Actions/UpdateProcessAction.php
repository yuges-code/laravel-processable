<?php

namespace Yuges\Processable\Actions;

use Throwable;
use Carbon\Carbon;
use Illuminate\Bus\Batch;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Enums\ProcessState;
use Yuges\Processable\Interfaces\ProcessState as ProcessStateInterface;

class UpdateProcessAction
{
    public function __construct(
        protected Process $process
    ) {
    }

    public static function create(Process $process): self
    {
        return new static($process);
    }

    public function execute(ProcessStateInterface $state, ?Batch $batch = null, ?Throwable $e = null): Process
    {
        $attributes = [
            'state' => $state,
            'batch_id' => $batch->id ?? $this->process->batch_id,
        ];

        match ($state->value) {
            ProcessState::Started->value => $attributes['started_at'] = Carbon::now(),
            ProcessState::Finished->value => $attributes['finished_at'] = Carbon::now(),
            ProcessState::Failed->value => $attributes['failed_at'] = Carbon::now(),
            default => null,
        };

        $this->process->update($attributes);

        return $this->process;
    }
}
