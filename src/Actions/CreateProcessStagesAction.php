<?php

namespace Yuges\Processable\Actions;

use Exception;
use Illuminate\Support\Collection;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Interfaces\Processable;
use Yuges\Processable\Enums\ProcessStatesEnum;
use Yuges\Processable\Interfaces\Process as ProcessInterface;

class CreateProcessStagesAction
{
    public function __construct(
        protected Processable $processable
    ) {
    }

    public static function create(Processable $processable): self
    {
        return new static($processable);
    }

    public function execute(Process $model): Process
    {
        $process = new $model->class;

        if (! $process instanceof ProcessInterface) {
            throw new Exception('error');
        }

        $stages = Collection::make($process->stages());

        $stages = $model->stages()->createMany(
            $stages->map(function (string $stage) {
                $stage = new $stage;

                return [
                    'class' => $stage::class,
                    'state' => ProcessStatesEnum::PENDING,
                ];
            })
        );

        return $model->setRelation('stages', $stages);
    }
}
