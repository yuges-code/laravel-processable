<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Traits\HasStages;
use Yuges\Processable\Traits\HasProcessable;
use Yuges\Processable\Traits\HasProcessState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yuges\Processable\Interfaces\Process as ProcessInterface;

/**
 * @property class-string<ProcessInterface> $class
 */
class Process extends Model
{
    use
        HasStages,
        HasFactory,
        HasProcessable,
        HasProcessState;

    protected $table = 'processes';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getProcessTable() ?? $this->table;
    }
}
