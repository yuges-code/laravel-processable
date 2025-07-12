<?php

namespace Yuges\Processable\Tests\Stubs\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Traits\HasProcesses;
use Yuges\Processable\Interfaces\Processable;

class Post extends Model implements Processable
{
    use HasProcesses;

    protected $table = 'posts';

    protected $guarded = ['id'];
}
