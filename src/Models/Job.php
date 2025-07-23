<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasUuids, HasFactory;

    protected $table = 'jobs';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getJobTable() ?? $this->table;
    }
}
