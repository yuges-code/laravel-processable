<?php

namespace Yuges\Processable\Exceptions;

use Exception;
use TypeError;
use Yuges\Processable\Models\Stage;

class InvalidStage extends Exception
{
    public static function doesNotImplementStage(string $class): TypeError
    {
        $stage = Stage::class;

        return new TypeError("Stage class `{$class}` must implement `{$stage}`");
    }
}
