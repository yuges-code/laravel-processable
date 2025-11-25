<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Traits\HasJob;
use Yuges\Processable\Traits\HasError;
use Yuges\Processable\Traits\HasFailedJob;
use Yuges\Processable\Traits\HasStageState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yuges\Processable\Interfaces\Stage as StageInterface;

/**
 * @property class-string<StageInterface> $class
 */
class Stage extends Model
{
    use
        HasJob,
        HasError,
        HasFactory,
        HasFailedJob,
        HasStageState;

    protected $table = 'process_stages';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getStageTable() ?? $this->table;
    }
}
