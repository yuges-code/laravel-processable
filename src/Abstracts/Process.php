<?php

namespace Yuges\Processable\Abstracts;

use Yuges\Processable\Models\Process as ProcessModel;

abstract class Process implements \Yuges\Processable\Interfaces\Process
{
    protected $name = 'Process';

    public function stages(): array
    {
        return [];
    }

    static function process(): ProcessModel
    {
        return self::createProcess();
    }

    public static function createProcess(): ProcessModel
    {
        return new ProcessModel();
    }
}
