<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Stage extends Model
{
    use HasFactory;

    protected $table = 'process_stages';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getProcessTable() ?? $this->table;
    }
}
