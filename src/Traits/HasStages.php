<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection<array-key, Stage> $stages
 * @property ?Stage $latestStage
 * @property ?Stage $oldestStage
 */
trait HasStages
{
    public function stages(): HasMany
    {
        /** @var Model $this */
        return $this->hasMany(Config::getStageClass(Stage::class));
    }

    public function latestStage(): HasOne
    {
        return $this->stages()->one()->latestOfMany();
    }

    public function oldestStage(): HasOne
    {
        return $this->stages()->one()->oldestOfMany();
    }
}
