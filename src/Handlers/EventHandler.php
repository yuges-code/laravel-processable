<?php

namespace Yuges\Processable\Handlers;

use Exception;
use Illuminate\Contracts\Queue\Job;
use Yuges\Processable\Config\Config;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Yuges\Processable\Jobs\ProcessStageJob;

class EventHandler
{
    /**
     * @var array{stage: StageEventHandler, process: ProcessEventHandler}
     */
    private array $handlers = [
        'stage' => null,
        'process' => null,
    ];

    public function __construct()
    {
        $this->handlers['stage'] = Config::getStageEventHandler(StageEventHandler::class);
        $this->handlers['process'] = Config::getProcessEventHandler(ProcessEventHandler::class);
    }

    public static function create(): self
    {
        return new static();
    }

    public function checkJob(Job $job): bool
    {
        return $job->resolveName() === Config::getProcessStageJobClass(ProcessStageJob::class);
    }

    public function getJobOrFail(Job $job): ProcessStageJob
    {
        $job = unserialize($job->payload()['data']['command']);

        if (! $job instanceof ProcessStageJob) {
            throw new Exception('Invalid job type');
        }

        return $job;
    }

    public function before(JobProcessing $event): void
    {
        if (! $this->checkJob($event->job)) {
            return;
        }

        $job = $this->getJobOrFail($event->job);

        $process = new ($job->getProcess()->class);

        if ($job->getStage()->class === $process->firstStage()) {
            $this->handlers['process']->before($event, $job);
        }

        $this->handlers['stage']->before($event, $job);
    }

    public function after(JobProcessed $event): void
    {
        if (! $this->checkJob($event->job)) {
            return;
        }

        $job = $this->getJobOrFail($event->job);

        $process = new ($job->getProcess()->class);

        $this->handlers['stage']->after($event, $job);

        if ($job->getStage()->class === $process->lastStage()) {
            $this->handlers['process']->after($event, $job);
        } else {
            $stage = $process->nextStage($job->getStage()->class);

            $job = Config::getCreateJobAction($job->getProcess(), $job->getProcessable())->execute($stage);

            dispatch($job)
                ->onConnection(Config::getQueueConnection())
                ->onQueue(Config::getQueueName());
        }
    }

    public function failing(JobFailed $event): void
    {
        if (! $this->checkJob($event->job)) {
            return;
        }

        $job = $this->getJobOrFail($event->job);

        $this->handlers['stage']->failing($event, $job);
        $this->handlers['process']->failing($event, $job);
    }
}
