<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Traits\HasState;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yuges\Processable\Interfaces\Process as ProcessInterface;

/**
 * @property Collection<array-key, Stage> $stages
 * @property class-string<ProcessInterface> $class
 */
class Process extends Model
{
    use HasFactory, HasState;

    protected $table = 'processes';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getProcessTable() ?? $this->table;
    }

    public function stages(): HasMany
    {
        return $this->hasMany(Config::getStageClass(Stage::class));
    }
}
