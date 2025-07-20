<?php

namespace Yuges\Processable\Providers;

use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Yuges\Package\Data\Package;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Observers\StageObserver;
use Yuges\Processable\Exceptions\InvalidStage;
use Yuges\Processable\Observers\ProcessObserver;
use Yuges\Processable\Exceptions\InvalidProcess;
use Yuges\Package\Providers\PackageServiceProvider;
use Illuminate\Support\Facades\Queue;
use Yuges\Processable\Jobs\ProcessStageJob;

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

    public function packageBooted(): void
    {
        Queue::before(function (JobProcessing $event) {
            $payload = $event->job->payload();

            $job = unserialize($payload['data']['command']);

            if (! $job instanceof ProcessStageJob) {
                return;
            }
        });

        Queue::after(function (JobProcessed $event) {
            // $event->connectionName
            // $event->job
            // $event->job->payload()
        });
    }
}
