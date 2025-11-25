<?php

namespace Yuges\Processable\Traits;

use Yuges\Package\Models\Model;
use Yuges\Processable\Models\Job;
use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|Job $job
 * @property null|int|string $job_id
 */
trait HasJob
{
    public function job(): BelongsTo
    {
        /** @var Model $this */
        return $this->belongsTo(Config::getJobClass(Job::class));
    }
}
