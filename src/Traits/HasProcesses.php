<?php

namespace Yuges\Processable\Traits;

use Illuminate\Support\Collection;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Yuges\Processable\Interfaces\Process as ProcessInterface;

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

    /**
     * @param class-string<ProcessInterface>
     */
    public function process(string $process): Process
    {
        $process = new $process();

        return Config::getRunProcessAction($this)->execute(
            Config::getCreateProcessAction($this)->execute($process)
        );
    }
}
