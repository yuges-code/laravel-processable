<?php

namespace Yuges\Processable\Config;

use Yuges\Package\Enums\KeyType;
use Illuminate\Support\Collection;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Observers\StageObserver;
use Yuges\Processable\Observers\ProcessObserver;
use Yuges\Processable\Observers\ProcessableObserver;

class Config extends \Yuges\Package\Config\Config
{
    const string NAME = 'processable';

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
}
