<?php

namespace Yuges\Processable\Enums;

enum StageState: int implements \Yuges\Processable\Interfaces\StageState
{
    case Pending = 10;
    case Started = 20;
    case Processing = 30;
    case Processed = 40;
    case Waiting = 50;
    case Resume = 60;
    case Finished = 70;
    case Failed = 80;
    case Aborted = 90;
    case Skipped = 100;

    public function getLabel(): string
    {
        return match ($this) {
            self::Pending => 'pending',
            self::Started => 'started',
            self::Processing => 'processing',
            self::Processed => 'processed',
            self::Waiting => 'waiting',
            self::Resume => 'resume',
            self::Finished => 'finished',
            self::Failed => 'failed',
            self::Aborted => 'aborted',
            self::Skipped => 'skipped',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Pending => 'gray',
            self::Started => 'info',
            self::Processing => 'warning',
            self::Processed => 'warning',
            self::Waiting => 'gray',
            self::Resume => 'info',
            self::Finished => 'success',
            self::Failed => 'danger',
            self::Aborted => 'danger',
            self::Skipped => 'danger',
        };
    }

    public static function default(): static
    {
        return self::Pending;
    }
}
