<?php

namespace Yuges\Processable\Actions;

use Exception;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Jobs\ProcessStageJob;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Interfaces\Stage as StageInterface;

class CreateJobAction
{
    public function __construct(
        protected Process $process,
        protected Processable $processable,
    ) {
    }

    public static function create(Process $process, Processable $processable): self
    {
        return new static($process, $processable);
    }

    /**
     * @param class-string<StageInterface>|null $stage
     */
    public function execute(?string $stage): ProcessStageJob
    {
        if (! $stage) {
            throw new Exception('Empty stage');
        }

        $stage = new $stage;

        if (! $stage instanceof StageInterface) {
            throw new Exception('Error stage type');
        }

        $stage = $this->process->stages->firstOrFail('class', '=', $stage::class);

        return Config::getProcessStageJob(
            $stage,
            $this->process,
            $this->processable,
            ProcessStageJob::class
        );
    }
}
