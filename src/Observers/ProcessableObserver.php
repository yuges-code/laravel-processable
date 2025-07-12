<?php

namespace Yuges\Processable\Observers;

use Yuges\Processable\Models\Stage;

class ProcessableObserver
{
    public function saving(Stage $model): void
    {

    }

    public function deleted(Stage $model): void
    {

    }
}
