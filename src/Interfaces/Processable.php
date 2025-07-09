<?php

namespace Yuges\Processable\Interfaces;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface Processable
{
    public function processes(): MorphMany;
}
