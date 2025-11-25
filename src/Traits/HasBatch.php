<?php

namespace Yuges\Processable\Traits;

use Yuges\Processable\Models\Batch;
use Yuges\Processable\Config\Config;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property null|Batch $batch
 * @property null|string $batch_id
 */
trait HasBatch
{
    public function batch(): BelongsTo
    {
        return $this->belongsTo(Config::getBatchClass(Batch::class));
    }
}
