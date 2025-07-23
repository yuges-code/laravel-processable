<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Models\Stage;
use Yuges\Processable\Enums\ProcessStatesEnum;

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

    public function execute(ProcessStatesEnum $state, ?string $jobId = null): Stage
    {
        $this->stage->update([
            'state' => $state,
            'job_id' => $jobId ?? $this->stage->job_id,
        ]);

        return $this->stage;
    }
}
