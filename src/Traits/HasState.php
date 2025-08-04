<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Enums\ProcessState;

/**
 * @property ProcessState $state
 */
trait HasState
{
    public function initializeHasState()
    {
        $this->mergeCasts([
            'state' => ProcessState::class,
        ]);
    }
}
