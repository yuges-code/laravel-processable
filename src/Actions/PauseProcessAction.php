<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Interfaces\Processable;

class PauseProcessAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    
}
