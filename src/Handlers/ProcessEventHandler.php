<?php

namespace Yuges\Processable\Handlers;

use Yuges\Processable\Config\Config;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Yuges\Processable\Jobs\ProcessStageJob;
use Yuges\Processable\Interfaces\ProcessState;

class ProcessEventHandler
{
    public static function create(): self
    {
        return new static();
    }

    public function before(JobProcessing $event, ProcessStageJob $job): void
    {
        Config::getUpdateProcessAction($job->getProcess())
            ->execute(Config::getProcessStateClass(ProcessState::class)::Started);
    }

    public function after(JobProcessed $event, ProcessStageJob $job): void
    {
        Config::getUpdateProcessAction($job->getProcess())
            ->execute(Config::getProcessStateClass(ProcessState::class)::Finished);
    }

    public function failing(JobFailed $event, ProcessStageJob $job): void
    {
        Config::getUpdateProcessAction($job->getProcess())
            ->execute(Config::getProcessStateClass(ProcessState::class)::Failed);
    }
}
