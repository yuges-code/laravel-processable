<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Interfaces\Processable;

class RunProcessAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    
}
