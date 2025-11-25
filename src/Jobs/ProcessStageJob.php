<?php

namespace Yuges\Processable\Jobs;

use Exception;
use Illuminate\Bus\Batchable;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Illuminate\Queue\SerializesModels;
use Yuges\Processable\Enums\StageState;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Actions\UpdateProcessStageAction;
use Yuges\Processable\Interfaces\Stage as StageInterface;

class ProcessStageJob implements ShouldQueue
{
    use Batchable, Queueable, SerializesModels;

    public function __construct(
        protected Stage $stage,
        protected Process $process,
        protected Processable $processable,
    ) {}

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $stage = new $this->stage->class;

        if (! $stage instanceof StageInterface) {
            throw new Exception('Stage type error');
        }

        $action = Config::getUpdateProcessStageAction(
            $this->stage,
            UpdateProcessStageAction::class
        );

        $this->stage = $action->execute(StageState::Processing, $this->job);

        $stage
            ->setStage($this->stage)
            ->setProcess($this->process)
            ->setProcessable($this->processable)
            ->execute();

        $this->stage = $action->execute(StageState::Processed, $this->job);
    }

    public function getStage(): Stage
    {
        return $this->stage;
    }
}
