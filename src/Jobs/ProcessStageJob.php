<?php

namespace Yuges\Processable\Jobs;

use Illuminate\Bus\Batchable;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Yuges\Processable\Enums\ProcessStatesEnum;

class ProcessStageJob implements ShouldQueue
{
    use Batchable, Queueable;

    public function __construct(
        protected Stage $stage
    ) {}

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $stage = new $this->stage->class;

        Config::getUpdateProcessStageAction($this->stage)->execute(ProcessStatesEnum::PROCESSING);

        $stage->execute();

        Config::getUpdateProcessStageAction($this->stage)->execute(ProcessStatesEnum::PROCESSED);
    }

    public function getStage(): Stage
    {
        return $this->stage;
    }
}
