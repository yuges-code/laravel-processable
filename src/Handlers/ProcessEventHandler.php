<?php

namespace Yuges\Processable\Handlers;

use Yuges\Processable\Config\Config;
use Illuminate\Queue\Events\JobFailed;
use Yuges\Processable\Enums\ProcessState;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Yuges\Processable\Jobs\ProcessStageJob;

class ProcessEventHandler
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

        Config::getUpdateProcessStageAction($job->getStage())->execute(ProcessState::Started);
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

        Config::getUpdateProcessStageAction($job->getStage())->execute(ProcessState::Finished);
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

        Config::getUpdateProcessStageAction($job->getStage())->execute(ProcessState::Failed);
    }
}
