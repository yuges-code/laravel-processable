<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Casts\AsError;
use Yuges\Processable\Error\StageError;
use Illuminate\Database\Eloquent\Model;

/**
 * @property StageError $error
 */
trait HasError
{
    public function initializeHasError()
    {
        /** @var Model $this */
        $this->mergeCasts([
            'error' => AsError::class,
        ]);
    }
}
