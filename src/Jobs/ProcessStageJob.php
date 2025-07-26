<?php

namespace Yuges\Processable\Jobs;

use Exception;
use Illuminate\Bus\Batchable;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Enums\ProcessStatesEnum;
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

        $this->stage = Config::getUpdateProcessStageAction($this->stage)->execute(ProcessStatesEnum::PROCESSING);

        $stage
            ->setStage($this->stage)
            ->setProcess($this->process)
            ->setProcessable($this->processable)
            ->execute();

        Config::getUpdateProcessStageAction($this->stage)->execute(ProcessStatesEnum::PROCESSED);
    }

    public function getStage(): Stage
    {
        return $this->stage;
    }
}
