<?php

namespace Yuges\Processable\Abstracts;

use Yuges\Processable\Models\Process;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Models\Stage as StageModel;

abstract class Stage implements \Yuges\Processable\Interfaces\Stage
{
    protected $name = 'Stage';

    protected Process $process;

    protected StageModel $stage;

    protected Processable $processable;

    public function execute()
    {
        return;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getStage(): StageModel
    {
        return $this->stage;
    }

    public function setStage(StageModel $stage): self
    {
        $this->stage = $stage;

        return $this;
    }

    public function getProcess(): Process
    {
        return $this->process;
    }

    public function setProcess(Process $process): self
    {
        $this->process = $process;

        return $this;
    }

    public function getProcessable(): Processable
    {
        return $this->processable;
    }

    public function setProcessable(Processable $processable): self
    {
        $this->processable = $processable;

        return $this;
    }
}
