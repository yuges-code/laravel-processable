<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Config\Config;
use Yuges\Processable\Enums\StageState;
use Illuminate\Database\Eloquent\Model;
use Yuges\Processable\Interfaces\StageState as StageStateInterface;

/**
 * @property StageStateInterface $state
 */
trait HasStageState
{
    public function initializeHasStageState()
    {
        /** @var Model $this */
        $this->mergeCasts([
            'state' => Config::getStageStateClass(StageState::class),
        ]);
    }
}
