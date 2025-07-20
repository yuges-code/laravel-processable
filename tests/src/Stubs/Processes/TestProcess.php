<?php

namespace Yuges\Processable\Tests\Stubs\Processes;

use Yuges\Processable\Abstracts\Process;
use Yuges\Processable\Tests\Stubs\Stages\StageOne;
use Yuges\Processable\Tests\Stubs\Stages\StageTwo;

class TestProcess extends Process
{
    public function stages(): array
    {
        return [
            StageOne::class,
            StageTwo::class,
        ];
    }
}
