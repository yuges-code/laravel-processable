<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Interfaces\Processable;

class RunProcessAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    public static function create(Processable $processable): self
    {
        return new static($processable);
    }

    public function execute(Process $process): Process
    {
        $stage = (new $process->class)->firstStage();

        $job = Config::getCreateJobAction($process, $this->processable)->execute($stage);

        dispatch($job)
            ->onConnection(Config::getQueueConnection())
            ->onQueue(Config::getQueueName());

        return $process;
    }
}
