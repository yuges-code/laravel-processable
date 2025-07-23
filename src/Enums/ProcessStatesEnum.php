<?php

namespace Yuges\Processable\Enums;

enum ProcessStatesEnum: int
{
    case PENDING = 10;
    case STARTED = 20;
    case PROCESSING = 30;
    case PROCESSED = 40;
    case WAITING = 50;
    case RESUME = 60;
    case FINISHED = 70;
    case FAILED = 80;
    case ABORTED = 90;
    case SKIPPED = 100;

    public function getLabel(): string
    {
        return match ($this) {
            self::PENDING => 'pending',
            self::STARTED => 'started',
            self::PROCESSING => 'processing',
            self::WAITING => 'waiting',
            self::RESUME => 'resume',
            self::FINISHED => 'completed',
            self::FAILED => 'failed',
            self::ABORTED => 'aborted',
            self::SKIPPED => 'skipped',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::PENDING => 'gray',
            self::STARTED => 'info',
            self::PROCESSING => 'warning',
            self::WAITING => 'gray',
            self::RESUME => 'info',
            self::FINISHED => 'success',
            self::FAILED => 'danger',
            self::ABORTED => 'danger',
            self::SKIPPED => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::PENDING => 'heroicon-m-clock',
            self::STARTED => 'heroicon-m-play',
            self::PROCESSING => 'heroicon-m-cog-6-tooth',
            self::WAITING => 'heroicon-m-clock',
            self::RESUME => 'heroicon-m-cog-6-tooth',
            self::FINISHED => 'heroicon-m-check',
            self::FAILED => 'heroicon-m-x-mark',
            self::ABORTED => 'heroicon-m-x-mark',
            self::SKIPPED => 'heroicon-m-x-mark',
        };
    }
}
