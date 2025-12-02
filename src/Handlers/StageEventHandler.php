<?php

namespace Yuges\Processable\Handlers;

use Yuges\Processable\Config\Config;
use Illuminate\Queue\Events\JobFailed;
use Yuges\Processable\Enums\StageState;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Yuges\Processable\Jobs\ProcessStageJob;

class StageEventHandler
{
    public static function create(): self
    {
        return new static();
    }

    public function before(JobProcessing $event, ProcessStageJob $job): void
    {
        Config::getUpdateProcessStageAction($job->getStage())
            ->execute(Config::getStageStateClass(StageState::class)::Started, $event->job);
    }

    public function after(JobProcessed $event, ProcessStageJob $job): void
    {
        Config::getUpdateProcessStageAction($job->getStage())
            ->execute(Config::getStageStateClass(StageState::class)::Finished, $event->job);
    }

    public function failing(JobFailed $event, ProcessStageJob $job): void
    {
        Config::getUpdateProcessStageAction($job->getStage())->execute(
            Config::getStageStateClass(StageState::class)::Failed,
            $event->job,
            $event->exception
        );
    }
}
