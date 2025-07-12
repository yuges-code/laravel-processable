<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Interfaces\Processable;

class CreateProcessAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    
}
