<?php

namespace Yuges\Processable\Actions;

use Throwable;
use Carbon\Carbon;
use Yuges\Processable\Models\Stage;
use Illuminate\Contracts\Queue\Job;
use Yuges\Processable\Enums\StageState;
use Yuges\Processable\Error\StageError;
use Yuges\Processable\Interfaces\StageState as StageStateInterface;

class UpdateProcessStageAction
{
    public function __construct(
        protected Stage $stage
    ) {
    }

    public static function create(Stage $stage): self
    {
        return new static($stage);
    }

    public function execute(StageStateInterface $state, ?Job $job = null, ?Throwable $e = null): Stage
    {
        $attributes = [
            'state' => $state,
            'job_uuid' => $job?->uuid() ?? $this->stage->job_uuid,
        ];

        if (
            $state->value != StageState::Failed->value &&
            $state->value != StageState::Finished->value
        ) {
            $attributes['job_id'] = $job?->getJobId() ?? $this->stage->job_id;
        }

        if ($e) {
            $attributes['error'] = new StageError(
                $e->getMessage(),
                $e->getCode(),
                $e->getFile(),
                $e->getLine(),
            );
        }

        match ($state->value) {
            StageState::Started->value => $attributes['started_at'] = Carbon::now(),
            StageState::Finished->value => $attributes['finished_at'] = Carbon::now(),
            StageState::Failed->value => $attributes['failed_at'] = Carbon::now(),
            default => null,
        };

        $this->stage->update($attributes);

        return $this->stage;
    }
}
