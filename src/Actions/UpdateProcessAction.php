<?php

namespace Yuges\Processable\Actions;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\Job;
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

    public function execute(ProcessStateInterface $state, ?Job $job = null): Process
    {
        $attributes = [
            'state' => $state,
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
