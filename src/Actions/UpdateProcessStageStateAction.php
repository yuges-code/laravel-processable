<?php

namespace Yuges\Processable\Actions;

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
        $this->stage->update([
            'state' => $state,
            'job_id' => $jobId ?? $this->stage->job_id,
        ]);

        return $this->stage;
    }
}
