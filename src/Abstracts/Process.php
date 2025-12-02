<?php

namespace Yuges\Processable\Abstracts;

use Illuminate\Support\Collection;
use Yuges\Processable\Models\Process as ProcessModel;

abstract class Process implements \Yuges\Processable\Interfaces\Process
{
    protected $name = 'Process';

    public function stages(): array
    {
        return [];
    }

    public function stageCollection(): Collection
    {
        return Collection::make($this->stages());
    }

    public function firstStage(): ?string
    {
        return $this->stageCollection()->first();
    }

    public function lastStage(): ?string
    {
        return $this->stageCollection()->last();
    }

    public function nextStage(?string $stage = null): ?string
    {
        $stages = $this->stageCollection();

        if (! $stage) {
            return $stages->first();
        }

        $key = $stages->search($stage);

        if ($key === false) {
            return null;
        }

        return $stages->get($key + 1);
    }

    static function process(): ProcessModel
    {
        return static::createProcess();
    }

    public static function createProcess(): ProcessModel
    {
        return new ProcessModel();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }
}
