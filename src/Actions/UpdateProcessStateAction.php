<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Interfaces\Processable;

class UpdateProcessStateAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    
}
