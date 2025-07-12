<?php

namespace Yuges\Processable\Providers;

use Yuges\Package\Data\Package;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Observers\StageObserver;
use Yuges\Processable\Exceptions\InvalidStage;
use Yuges\Processable\Observers\ProcessObserver;
use Yuges\Processable\Exceptions\InvalidProcess;
use Yuges\Package\Providers\PackageServiceProvider;

class ProcessableServiceProvider extends PackageServiceProvider
{
    protected string $name = 'laravel-processable';

    public function configure(Package $package): void
    {
        $stage = Config::getStageClass(Stage::class);
        $process = Config::getProcessClass(Process::class);

        if (! is_a($stage, Stage::class, true)) {
            throw InvalidStage::doesNotImplementStage($stage);
        }

        if (! is_a($process, Process::class, true)) {
            throw InvalidProcess::doesNotImplementProcess($process);
        }

        $package
            ->hasName($this->name)
            ->hasConfig('processable')
            ->hasMigrations([
                '000_create_processes_table',
                '001_create_process_stages_table',
            ])
            ->hasObserver($stage, Config::getStageObserverClass(StageObserver::class))
            ->hasObserver($process, Config::getProcessObserverClass(ProcessObserver::class));
    }
}
