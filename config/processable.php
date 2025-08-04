<?php

// Config for yuges/processable

return [
    /*
     * FQCN (Fully Qualified Class Name) of the models to use for process
     */
    'models' => [
        'job' => [
            'table' => 'jobs',
            'class' => Yuges\Processable\Models\Job::class,
        ],
        'batch' => [
            'table' => 'job_batches',
            'class' => Yuges\Processable\Models\Batch::class,
        ],
        'stage' => [
            'key' => Yuges\Package\Enums\KeyType::BigInteger,
            'table' => 'process_stages',
            'class' => Yuges\Processable\Models\Stage::class,
            'observer' => Yuges\Processable\Observers\StageObserver::class,
        ],
        'process' => [
            'key' => Yuges\Package\Enums\KeyType::BigInteger,
            'table' => 'processes',
            'class' => Yuges\Processable\Models\Process::class,
            'observer' => Yuges\Processable\Observers\ProcessObserver::class,
        ],
        'processable' => [
            'key' => Yuges\Package\Enums\KeyType::BigInteger,
            'allowed' => [
                'classes' => [
                    // \App\Models\User::class,
                ],
            ],
            'relation' => [
                'name' => 'processable',
            ],
            'observer' => Yuges\Processable\Observers\ProcessableObserver::class,
        ],
    ],

    'actions' => [
        'stage' => [
            'create' => Yuges\Processable\Actions\CreateProcessStagesAction::class,
            'update' => Yuges\Processable\Actions\UpdateProcessStageStateAction::class,
        ],
        'process' => [
            'run' => Yuges\Processable\Actions\RunProcessAction::class,
            'create' => Yuges\Processable\Actions\CreateProcessAction::class,
            'update' => Yuges\Processable\Actions\UpdateProcessStateAction::class,
        ],
    ],

    'job' => [
        'class' => Yuges\Processable\Jobs\ProcessStageJob::class,
        'handler' => [
            'stage' => Yuges\Processable\Handlers\StageEventHandler::class,
            'process' => Yuges\Processable\Handlers\StageEventHandler::class,
        ],
        'queue' => [
            'name' => env('PROCESS_QUEUE', ''),
            'connection' => env('QUEUE_CONNECTION', 'sync'),
        ],
    ],
];
