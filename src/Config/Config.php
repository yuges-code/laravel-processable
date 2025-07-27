<?php

namespace Yuges\Processable\Config;

use Yuges\Package\Enums\KeyType;
use Yuges\Processable\Models\Job;
use Illuminate\Support\Collection;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Models\Batch;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Jobs\ProcessStageJob;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Observers\StageObserver;
use Yuges\Processable\Actions\RunProcessAction;
use Yuges\Processable\Observers\ProcessObserver;
use Yuges\Processable\Handlers\StageEventHandler;
use Yuges\Processable\Actions\CreateProcessAction;
use Yuges\Processable\Observers\ProcessableObserver;
use Yuges\Processable\Actions\UpdateProcessStateAction;
use Yuges\Processable\Actions\CreateProcessStagesAction;
use Yuges\Processable\Actions\UpdateProcessStageStateAction;

class Config extends \Yuges\Package\Config\Config
{
    const string NAME = 'processable';

    public static function getJobTable(mixed $default = null): string
    {
        return self::get('models.job.table', $default);
    }

    /** @return class-string<Job> */
    public static function getJobClass(mixed $default = null): string
    {
        return self::get('models.job.class', $default);
    }

    public static function getBatchTable(mixed $default = null): string
    {
        return self::get('models.batch.table', $default);
    }

    public static function getBatch(mixed $default = null): Batch
    {
        $batch = self::getBatchClass($default);

        return new $batch;
    }

    /** @return class-string<Batch> */
    public static function getBatchClass(mixed $default = null): string
    {
        return self::get('models.batch.class', $default);
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

    public static function getProcessKeyType(mixed $default = null): KeyType
    {
        return self::get('models.process.key', $default);
    }

    /** @return class-string<ProcessObserver> */
    public static function getProcessObserverClass(mixed $default = null): string
    {
        return self::get('models.process.observer', $default);
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

    public static function getStageKeyType(mixed $default = null): KeyType
    {
        return self::get('models.stage.key', $default);
    }

    /** @return class-string<StageObserver> */
    public static function getStageObserverClass(mixed $default = null): string
    {
        return self::get('models.stage.observer', $default);
    }

    public static function getProcessableKeyType(mixed $default = null): KeyType
    {
        return self::get('models.processable.key', $default);
    }

    public static function getProcessableRelationName(mixed $default = null): string
    {
        return self::get('models.processable.relation.name', $default);
    }

    /** @return Collection<array-key, class-string<Processable>> */
    public static function getProcessableAllowedClasses(mixed $default = null): Collection
    {
        return Collection::make(
            self::get('models.processable.allowed.classes', $default)
        );
    }

    /** @return class-string<ProcessableObserver> */
    public static function getProcessableObserverClass(mixed $default = null): string
    {
        return self::get('models.processable.observer', $default);
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
        Processable $processable,
        mixed $default = null
    ): UpdateProcessStateAction
    {
        return self::getUpdateProcessActionClass($default)::create($processable);
    }

    /** @return class-string<UpdateProcessStateAction> */
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
    ): UpdateProcessStageStateAction
    {
        return self::getUpdateProcessStageActionClass($default)::create($stage);
    }

    /** @return class-string<UpdateProcessStageStateAction> */
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
}
