<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Process extends Model
{
    use HasFactory;

    protected $table = 'processes';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getProcessTable() ?? $this->table;
    }
}
