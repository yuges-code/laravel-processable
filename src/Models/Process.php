<?php

namespace Yuges\Processable\Models;

use Yuges\Package\Models\Model;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Enums\StageState;
use Yuges\Processable\Traits\HasStages;
use Illuminate\Support\Facades\Artisan;
use Yuges\Processable\Traits\HasProcessable;
use Yuges\Processable\Traits\HasProcessState;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Yuges\Processable\Interfaces\Process as ProcessInterface;

/**
 * @property class-string<ProcessInterface> $class
 */
class Process extends Model
{
    use
        HasStages,
        HasFactory,
        HasProcessable,
        HasProcessState;

    protected $table = 'processes';

    protected $guarded = ['id'];

    public function getTable(): string
    {
        return Config::getProcessTable() ?? $this->table;
    }

    public function retry(): self
    {
        /** @var ?Stage */
        $stage = $this->stages()->getQuery()
            ->where('state', '=', Config::getStageStateClass(StageState::class)::Failed)
            ->first();

        if (! $stage?->job_uuid) {
            return $this;
        }

        Artisan::call("queue:retry {$stage->job_uuid}");

        return $this;
    }
}
