<?php

namespace Yuges\Processable\Handlers;

use Yuges\Processable\Config\Config;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Yuges\Processable\Jobs\ProcessStageJob;
use Yuges\Processable\Enums\ProcessStatesEnum;

class StageEventHandler
{
    public static function create(): self
    {
        return new static();
    }

    public function before(JobProcessing $event): void
    {
        if ($event->job->resolveName() != Config::getProcessStageJobClass(ProcessStageJob::class))
        {
            return;
        }

        $payload = $event->job->payload();
        $job = unserialize($payload['data']['command']);

        if (! $job instanceof ProcessStageJob) {
            return;
        }

        Config::getUpdateProcessStageAction($job->getStage())->execute(ProcessStatesEnum::STARTED, $event->job->getJobId());
    }

    public function after(JobProcessed $event): void
    {
        if ($event->job->resolveName() != Config::getProcessStageJobClass(ProcessStageJob::class))
        {
            return;
        }

        $payload = $event->job->payload();
        $job = unserialize($payload['data']['command']);

        if (! $job instanceof ProcessStageJob) {
            return;
        }

        Config::getUpdateProcessStageAction($job->getStage())->execute(ProcessStatesEnum::FINISHED);
    }

    public function failing(JobFailed $event): void
    {
        if ($event->job->resolveName() != Config::getProcessStageJobClass(ProcessStageJob::class))
        {
            return;
        }

        $payload = $event->job->payload();
        $job = unserialize($payload['data']['command']);

        if (! $job instanceof ProcessStageJob) {
            return;
        }

        Config::getUpdateProcessStageAction($job->getStage())->execute(ProcessStatesEnum::FAILED);
    }
}
