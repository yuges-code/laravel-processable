<?php

namespace Yuges\Processable\Actions;

use Carbon\Carbon;
use Yuges\Processable\Models\Stage;
use Illuminate\Contracts\Queue\Job;
use Yuges\Processable\Enums\StageState;
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

    public function execute(StageStateInterface $state, ?Job $job = null): Stage
    {
        $attributes = [
            'state' => $state,
            'job_id' => $job?->getJobId() ?? $this->stage->job_id,
            'job_uuid' => $job?->uuid() ?? $this->stage->job_uuid,
        ];

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
