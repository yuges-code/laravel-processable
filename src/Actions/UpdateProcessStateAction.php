<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Interfaces\Processable;

class UpdateProcessStateAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    public static function create(Processable $processable): self
    {
        return new static($processable);
    }
}
