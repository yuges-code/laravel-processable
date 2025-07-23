<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Traits\HasState;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yuges\Processable\Interfaces\Stage as StageInterface;

/**
 * @property class-string<StageInterface> $class
 */
class Stage extends Model
{
    use HasFactory, HasState;

    protected $table = 'process_stages';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getStageTable() ?? $this->table;
    }

    public function job(): BelongsTo
    {
        return $this->belongsTo(Config::getJobClass(Job::class));
    }
}
