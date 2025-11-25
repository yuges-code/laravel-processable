<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Model;
use Yuges\Processable\Enums\ProcessState;
use Yuges\Processable\Interfaces\ProcessState as ProcessStateInterface;

/**
 * @property ProcessStateInterface $state
 */
trait HasProcessState
{
    public function initializeHasProcessState()
    {
        /** @var Model $this */
        $this->mergeCasts([
            'state' => Config::getProcessStateClass(ProcessState::class),
        ]);
    }
}
