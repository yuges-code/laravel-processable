<?php

namespace Yuges\Processable\Interfaces;

use Yuges\Processable\Models\Process;
use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Processable
{
    public function processes(): MorphMany;

    public function process(Process $process): static;
}
