<?php

namespace Yuges\Processable\Tests\Stubs\Stages;

use Yuges\Processable\Abstracts\Stage;

class StageTwo extends Stage
{
    public function execute()
    {
        40*50;
    }
}
