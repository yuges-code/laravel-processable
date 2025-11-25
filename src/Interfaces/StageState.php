<?php

namespace Yuges\Processable\Interfaces;

use BackedEnum;

interface StageState extends BackedEnum
{
    public function getLabel(): string;

    public function getColor(): string;

    public static function default(): static;
}
