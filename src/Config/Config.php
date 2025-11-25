<?php

namespace Yuges\Processable\Config;

use Yuges\Package\Enums\KeyType;
use Yuges\Processable\Models\Job;
use Illuminate\Support\Collection;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Models\Batch;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Enums\StageState;
use Yuges\Processable\Models\FailedJob;
use Yuges\Processable\Enums\ProcessState;
use Yuges\Processable\Jobs\ProcessStageJob;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Observers\StageObserver;
use Yuges\Processable\Actions\RunProcessAction;
use Yuges\Processable\Observers\ProcessObserver;
use Yuges\Processable\Handlers\StageEventHandler;
use Yuges\Processable\Actions\UpdateProcessAction;
use Yuges\Processable\Actions\CreateProcessAction;
use Yuges\Processable\Observers\ProcessableObserver;
use Yuges\Processable\Actions\UpdateProcessStageAction;
use Yuges\Processable\Actions\CreateProcessStagesAction;

class Config extends \Yuges\Package\Config\Config
{
    const string NAME = 'processable';

    public static function getJobKeyHas(mixed $default = null): bool
    {
        return self::get('models.job.key.has', $default);
    }

    public static function getJobKeyType(mixed $default = null): KeyType
    {
        return self::get('models.job.key.type', $default);
    }

    public static function getJobTable(mixed $default = null): string
    {
        return self::get('models.job.table', $default);
    }

    /** @return class-string<Job> */
    public static function getJobClass(mixed $default = null): string
    {
        return self::get('models.job.class', $default);
    }

    public static function getJobRelationName(mixed $default = null): string
    {
        return self::get('models.job.relation.name', $default);
    }

    /** @return class-string<JobObserver> */
    public static function getJobObserverClass(mixed $default = null): string
    {
        return self::get('models.job.observer', $default);
    }

    public static function getBatchKeyHas(mixed $default = null): bool
    {
        return self::get('models.batch.key.has', $default);
    }

    public static function getBatchKeyType(mixed $default = null): KeyType
    {
        return self::get('models.batch.key.type', $default);
    }

    public static function getBatchTable(mixed $default = null): string
    {
        return self::get('models.batch.table', $default);
    }

    /** @return class-string<Batch> */
    public static function getBatchClass(mixed $default = null): string
    {
        return self::get('models.batch.class', $default);
    }

    public static function getBatchRelationName(mixed $default = null): string
    {
        return self::get('models.batch.relation.name', $default);
    }

    /** @return class-string<BatchObserver> */
    public static function getBatchObserverClass(mixed $default = null): string
    {
        return self::get('models.batch.observer', $default);
    }

    public static function getStageKeyHas(mixed $default = null): bool
    {
        return self::get('models.stage.key.has', $default);
    }

    public static function getStageKeyType(mixed $default = null): KeyType
    {
        return self::get('models.stage.key.type', $default);
    }

    public static function getStageTable(mixed $default = null): string
    {
        return self::get('models.stage.table', $default);
    }

    /** @return class-string<Stage> */
    public static function getStageClass(mixed $default = null): string
    {
        return self::get('models.stage.class', $default);
    }

    public static function getStageRelationName(mixed $default = null): string
    {
        return self::get('models.stage.relation.name', $default);
    }

    /** @return class-string<StageObserver> */
    public static function getStageObserverClass(mixed $default = null): string
    {
        return self::get('models.stage.observer', $default);
    }

    public static function getFailedJobKeyHas(mixed $default = null): bool
    {
        return self::get('models.failed.key.has', $default);
    }

    public static function getFailedJobKeyType(mixed $default = null): KeyType
    {
        return self::get('models.failed.key.type', $default);
    }

    public static function getFailedJobTable(mixed $default = null): string
    {
        return self::get('models.failed.table', $default);
    }

    /** @return class-string<FailedJob> */
    public static function getFailedJobClass(mixed $default = null): string
    {
        return self::get('models.failed.class', $default);
    }

    public static function getFailedJobRelationName(mixed $default = null): string
    {
        return self::get('models.failed.relation.name', $default);
    }

    /** @return class-string<FailedJobObserver> */
    public static function getFailedJobObserverClass(mixed $default = null): string
    {
        return self::get('models.failed.observer', $default);
    }

    public static function getProcessKeyHas(mixed $default = null): bool
    {
        return self::get('models.process.key.has', $default);
    }

    public static function getProcessKeyType(mixed $default = null): KeyType
    {
        return self::get('models.process.key.type', $default);
    }

    public static function getProcessTable(mixed $default = null): string
    {
        return self::get('models.process.table', $default);
    }

    /** @return class-string<Process> */
    public static function getProcessClass(mixed $default = null): string
    {
        return self::get('models.process.class', $default);
    }

    public static function getProcessRelationName(mixed $default = null): string
    {
        return self::get('models.process.relation.name', $default);
    }

    /** @return class-string<ProcessObserver> */
    public static function getProcessObserverClass(mixed $default = null): string
    {
        return self::get('models.process.observer', $default);
    }

    public static function getProcessableKeyHas(mixed $default = null): bool
    {
        return self::get('models.processable.key.has', $default);
    }

    public static function getProcessableKeyType(mixed $default = null): KeyType
    {
        return self::get('models.processable.key.type', $default);
    }

    /** @return Collection<array-key, class-string<Processable>> */
    public static function getProcessableAllowedClasses(mixed $default = null): Collection
    {
        return Collection::make(
            self::get('models.processable.allowed.classes', $default)
        );
    }

    public static function getProcessableRelationName(mixed $default = null): string
    {
        return self::get('models.processable.relation.name', $default);
    }

    /** @return class-string<ProcessableObserver> */
    public static function getProcessableObserverClass(mixed $default = null): string
    {
        return self::get('models.processable.observer', $default);
    }

    /** @return class-string<StageState> */
    public static function getStageStateClass(mixed $default = null): string
    {
        return self::get('stage.state', $default);
    }

    /** @return class-string<ProcessState> */
    public static function getProcessStateClass(mixed $default = null): string
    {
        return self::get('process.state', $default);
    }

    public static function getRunProcessAction(
        Processable $processable,
        mixed $default = null
    ): RunProcessAction
    {
        return self::getRunProcessActionClass($default)::create($processable);
    }

    /** @return class-string<RunProcessAction> */
    public static function getRunProcessActionClass(mixed $default = null): string
    {
        return self::get('actions.process.run', $default);
    }

    public static function getCreateProcessAction(
        Processable $processable,
        mixed $default = null
    ): CreateProcessAction
    {
        return self::getCreateProcessActionClass($default)::create($processable);
    }

    /** @return class-string<CreateProcessAction> */
    public static function getCreateProcessActionClass(mixed $default = null): string
    {
        return self::get('actions.process.create', $default);
    }

    public static function getUpdateProcessAction(
        Process $process,
        mixed $default = null
    ): UpdateProcessAction
    {
        return self::getUpdateProcessActionClass($default)::create($process);
    }

    /** @return class-string<UpdateProcessAction> */
    public static function getUpdateProcessActionClass(mixed $default = null): string
    {
        return self::get('actions.process.update', $default);
    }

    public static function getCreateProcessStagesAction (
        Processable $processable,
        mixed $default = null
    ): CreateProcessStagesAction
    {
        return self::getCreateProcessStagesActionClass($default)::create($processable);
    }

    /** @return class-string<CreateProcessStagesAction> */
    public static function getCreateProcessStagesActionClass(mixed $default = null): string
    {
        return self::get('actions.stage.create', $default);
    }

    public static function getUpdateProcessStageAction (
        Stage $stage,
        mixed $default = null
    ): UpdateProcessStageAction
    {
        return self::getUpdateProcessStageActionClass($default)::create($stage);
    }

    /** @return class-string<UpdateProcessStageAction> */
    public static function getUpdateProcessStageActionClass(mixed $default = null): string
    {
        return self::get('actions.stage.update', $default);
    }

    public static function getProcessStageJob(
        Stage $stage,
        Process $process,
        Processable $processable,
        mixed $default = null
    ): ProcessStageJob
    {
        $job = self::getProcessStageJobClass($default);

        return new $job($stage, $process, $processable);
    }

    /** @return class-string<ProcessStageJob> */
    public static function getProcessStageJobClass(mixed $default = null): string
    {
        return self::get('job.class', $default);
    }

    public static function getStageEventHandler(mixed $default = null): StageEventHandler
    {
        return self::getStageEventHandlerClass($default)::create();
    }

    /** @return class-string<StageEventHandler> */
    public static function getStageEventHandlerClass(mixed $default = null): string
    {
        return self::get('job.handler.stage', $default);
    }

    public static function getQueueName(mixed $default = null): string
    {
        return self::get('job.queue.name', $default);
    }

    public static function getQueueConnection(mixed $default = null): string
    {
        return self::get('job.queue.connection', $default);
    }
}
