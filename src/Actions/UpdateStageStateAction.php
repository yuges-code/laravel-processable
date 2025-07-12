<?php

namespace Yuges\Processable\Actions;

use Yuges\Processable\Interfaces\Processable;

class UpdateStageStateAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    
}
