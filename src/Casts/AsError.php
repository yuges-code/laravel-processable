<?php

namespace Yuges\Processable\Casts;

use InvalidArgumentException;
use Yuges\Processable\Error\StageError;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class AsError implements CastsAttributes
{
    public function get(
        Model $model,
        string $key,
        mixed $value,
        array $attributes,
    ): ?StageError {
        $value = json_decode($value, true);

        if (! is_array($value)) {
            return null;
        }

        return new StageError(...$value);
    }

    public function set(
        Model $model,
        string $key,
        mixed $value,
        array $attributes,
    ): ?string {
        if (! $value) {
            return null;
        }

        if (! $value instanceof StageError) {
            throw new InvalidArgumentException('The given value is not an StageError instance.');
        }

        return json_encode($value);
    }
}
