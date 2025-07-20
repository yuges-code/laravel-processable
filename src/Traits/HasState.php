<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Enums\ProcessStatesEnum;

/**
 * @property ProcessStatesEnum $state
 */
trait HasState
{
    public function initializeHasState()
    {
        $this->mergeCasts([
            'state' => ProcessStatesEnum::class,
        ]);
    }
}
