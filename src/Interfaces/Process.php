<?php

namespace Yuges\Processable\Interfaces;

use Yuges\Processable\Models\Process as ProcessModel;

interface Process
{
    public function stages(): array;

    static function process(): ProcessModel;

    public function getName(): string;

    public function setName(string $name): self;
}
