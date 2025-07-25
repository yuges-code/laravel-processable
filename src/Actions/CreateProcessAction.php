<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Enums\ProcessStatesEnum;
use Yuges\Processable\Interfaces\Process as ProcessInterface;

class CreateProcessAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    public static function create(Processable $processable): self
    {
        return new static($processable);
    }

    public function execute(ProcessInterface $process): Process
    {
        $model = $this->processable->processes()->create([
            'class' => $process::class,
            'state' => ProcessStatesEnum::PENDING,
        ]);

        return Config::getCreateProcessStagesAction($this->processable)->execute($model);
    }
}
