<?php

namespace Yuges\Processable\Traits;

use Illuminate\Support\Collection;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

/**
 * @property Collection<array-key, Process> $processes
 */
trait HasProcesses
{
    public function processes(): MorphMany
    {
        /** @var Model $this */
        return $this
            ->MorphMany(
                Config::getProcessClass(Process::class),
                Config::getProcessableRelationName('processable'),
            );
    }

    public function process(Process $process): static
    {
        return $this;
    }

    public function unprocess(Process $process): static
    {
        return $this;
    }
}
