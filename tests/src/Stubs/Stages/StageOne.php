<?php

namespace Yuges\Processable\Tests\Stubs\Stages;

use Yuges\Processable\Abstracts\Stage;

class StageOne extends Stage
{
    public function execute()
    {
        10*20;
    }
}
