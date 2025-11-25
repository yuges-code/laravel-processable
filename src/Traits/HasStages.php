<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property Collection<array-key, Stage> $stages
 */
trait HasStages
{
    public function stages(): HasMany
    {
        /** @var Model $this */
        return $this->hasMany(Config::getStageClass(Stage::class));
    }
}
