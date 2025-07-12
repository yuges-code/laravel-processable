<?php

namespace Yuges\Processable\Exceptions;

use Exception;
use TypeError;
use Yuges\Processable\Models\Process;

class InvalidProcess extends Exception
{
    public static function doesNotImplementProcess(string $class): TypeError
    {
        $process = Process::class;

        return new TypeError("Process class `{$class}` must implement `{$process}`");
    }
}
