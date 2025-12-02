<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Config\Config;
use Yuges\Processable\Interfaces\Processable;
use Illuminate\Database\Eloquent\Relations\MorphTo;

/**
 * @property string $processable_type
 * @property int|string $processable_id
 * 
 * @property ?Processable $processable
 */
trait HasProcessable
{
    public function processable(): MorphTo
    {
        /** @var Model $this */
        return $this->morphTo(Config::getProcessableRelationName('processable'));
    }
}
