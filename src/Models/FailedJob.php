<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FailedJob extends Model
{
    use HasFactory;

    protected $table = 'failed_jobs';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getJobTable() ?? $this->table;
    }
}
