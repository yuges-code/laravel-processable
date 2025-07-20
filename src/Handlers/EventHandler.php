<?php

namespace Yuges\Processable\Handlers;

use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Yuges\Processable\Config\Config;

class EventHandler
{
    public static function before(JobProcessing $event): void
    {
        Config::getUpdateProcessStageAction();
    }

    public static function after(JobProcessed $event): void
    {
        
    }

    public static function failing(JobFailed $event): void
    {

    }
}
