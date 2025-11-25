<?php

namespace Yuges\Processable\Traits;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\FailedJob;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|FailedJob $failedJob
 * @property null|int|string $job_uuid
 */
trait HasFailedJob
{
    public function failedJob(): BelongsTo
    {
        /** @var Model $this */
        return $this->belongsTo(
            Config::getFailedJobClass(FailedJob::class),
            'job_uuid',
            'uuid',
        );
    }
}
