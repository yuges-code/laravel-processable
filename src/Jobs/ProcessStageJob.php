<?php

namespace Yuges\Processable\Jobs;

use Exception;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Enums\StageState;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Actions\UpdateProcessAction;
use Yuges\Processable\Actions\UpdateProcessStageAction;
use Yuges\Processable\Enums\ProcessState;
use Yuges\Processable\Interfaces\Stage as StageInterface;

class ProcessStageJob implements ShouldQueue
{
    use Queueable;

    /**
     * @var array{stage: UpdateProcessStageAction, process: UpdateProcessAction}
     */
    private array $actions = [
        'stage' => null,
        'process' => null,
    ];

    public function __construct(
        protected Stage $stage,
        protected Process $process,
        protected Processable $processable,
    ) {
        $this->actions['stage'] = Config::getUpdateProcessStageAction($this->stage, UpdateProcessStageAction::class);
        $this->actions['process'] = Config::getUpdateProcessAction($this->process, UpdateProcessAction::class);
    }

    public function handle(): void
    {
        $stage = new $this->stage->class;

        if (! $stage instanceof StageInterface) {
            throw new Exception('Stage type error');
        }

        $this->stage = $this->actions['stage']
            ->execute(Config::getStageStateClass(StageState::class)::Processing, $this->job);

        $this->actions['process']->execute(Config::getProcessStateClass(ProcessState::class)::Processing, $this->job);

        $stage
            ->setStage($this->stage)
            ->setProcess($this->process)
            ->setProcessable($this->processable)
            ->execute();

        $this->stage = $this->actions['stage']
            ->execute(Config::getStageStateClass(StageState::class)::Processed, $this->job);

        $process = new ($this->process->class);

        if ($this->stage->class === $process->lastStage()) {
            $this->actions['process']
                ->execute(Config::getProcessStateClass(ProcessState::class)::Processed, $this->job);
        }
    }

    public function getStage(): Stage
    {
        return $this->stage;
    }

    public function getProcess(): Process
    {
        return $this->process;
    }

    public function getProcessable(): Processable
    {
        return $this->processable;
    }
}
