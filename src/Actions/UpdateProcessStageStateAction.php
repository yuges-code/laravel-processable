<?php

namespace Yuges\Processable\Actions;

use Carbon\Carbon;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Enums\ProcessState;

class UpdateProcessStageStateAction
{
    public function __construct(
        protected Stage $stage
    ) {
    }

    public static function create(Stage $stage): self
    {
        return new static($stage);
    }

    public function execute(ProcessState $state, ?string $jobId = null): Stage
    {
        $attributes = [
            'state' => $state,
            'job_id' => $jobId ?? $this->stage->job_id,
        ];

        if ($state === ProcessState::Failed) {
            $attributes['failed_at'] = Carbon::now();
        }

        $this->stage->update($attributes);

        return $this->stage;
    }
}
