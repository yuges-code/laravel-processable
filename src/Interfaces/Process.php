<?php

namespace Yuges\Processable\Interfaces;

use Illuminate\Support\Collection;
use Yuges\Processable\Models\Process as ProcessModel;
use Yuges\Processable\Interfaces\Stage as StageInterface;

interface Process
{
    /**
     * @return array<array-key, class-string<StageInterface>>
     */
    public function stages(): array;

    /**
     * @return Collection<array-key, class-string<StageInterface>>
     */
    public function stageCollection(): Collection;

    /**
     * @return class-string<StageInterface>|null
     */
    public function firstStage(): ?string;

    /**
     * @return class-string<StageInterface>|null
     */
    public function lastStage(): ?string;

    /**
     * @param class-string<StageInterface>|null $stage
     * 
     * @return class-string<StageInterface>|null
     */
    public function nextStage(?string $stage = null): ?string;

    static function process(): ProcessModel;

    public function getName(): string;

    public function setName(string $name): static;
}
