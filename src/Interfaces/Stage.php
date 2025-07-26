<?php

namespace Yuges\Processable\Interfaces;

use Yuges\Processable\Models\Process;
use Yuges\Processable\Models\Stage as StageModel;

interface Stage
{
    public function execute();

    public function getName(): string;

    public function setName(string $name): self;

    public function getStage(): StageModel;

    public function setStage(StageModel $stage): self;

    public function getProcess(): Process;

    public function setProcess(Process $process): self;

    public function getProcessable(): Processable;

    public function setProcessable(Processable $processable): self;
}
