<?php

namespace Yuges\Processable\Jobs;

use Illuminate\Bus\Batchable;
use Yuges\Processable\Models\Stage;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessStageJob implements ShouldQueue
{
    use Batchable, Queueable;

    public function __construct(
        protected Stage $stage
    ) {}

    public function handle(): void
    {
        if ($this->batch()->cancelled()) {
            return;
        }

        $stage = new $this->stage->class;
        
        $stage->execute();
    }

    public function failed()
    {

    }
}