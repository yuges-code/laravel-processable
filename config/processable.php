<?php

// Config for yuges/processable

return [
    /*
     * FQCN (Fully Qualified Class Name) of the models to use for processes
     */
    'models' => [
        'job' => [
            'key' => [
                'has' => true,
                'type' => Yuges\Package\Enums\KeyType::BigInteger,
            ],
            'table' => 'jobs',
            'class' => Yuges\Processable\Models\Job::class,
            'relation' => [
                'name' => 'job',
            ],
            'observer' => null,
        ],
        'batch' => [
            'key' => [
                'has' => true,
                'type' => Yuges\Package\Enums\KeyType::Uuid,
            ],
            'table' => 'job_batches',
            'class' => Yuges\Processable\Models\Batch::class,
            'relation' => [
                'name' => 'batch',
            ],
            'observer' => null,
        ],
        'stage' => [
            'key' => [
                'has' => true,
                'type' => Yuges\Package\Enums\KeyType::BigInteger,
            ],
            'table' => 'process_stages',
            'class' => Yuges\Processable\Models\Stage::class,
            'relation' => [
                'name' => 'stage',
            ],
            'observer' => Yuges\Processable\Observers\StageObserver::class,
        ],
        'failed' => [
            'key' => [
                'has' => true,
                'type' => Yuges\Package\Enums\KeyType::BigInteger,
            ],
            'table' => 'failed_jobs',
            'class' => Yuges\Processable\Models\FailedJob::class,
            'relation' => [
                'name' => 'failedJob',
            ],
            'observer' => null,
        ],
        'process' => [
            'key' => [
                'has' => true,
                'type' => Yuges\Package\Enums\KeyType::BigInteger,
            ],
            'table' => 'processes',
            'class' => Yuges\Processable\Models\Process::class,
            'relation' => [
                'name' => 'process',
            ],
            'observer' => Yuges\Processable\Observers\ProcessObserver::class,
        ],
        'processable' => [
            'key' => [
                'has' => true,
                'type' => Yuges\Package\Enums\KeyType::BigInteger,
            ],
            'allowed' => [
                'classes' => [
                    # models...
                ],
            ],
            'relation' => [
                'name' => 'processable',
            ],
            'observer' => Yuges\Processable\Observers\ProcessableObserver::class,
        ],
    ],

    'stage' => [
        'state' => Yuges\Processable\Enums\StageState::class,
    ],
    'process' => [
        'state' => Yuges\Processable\Enums\ProcessState::class,
    ],

    'actions' => [
        'job' => [
            'create' => Yuges\Processable\Actions\CreateJobAction::class,
        ],
        'stage' => [
            'update' => Yuges\Processable\Actions\UpdateProcessStageAction::class,
            'create' => Yuges\Processable\Actions\CreateProcessStagesAction::class,
        ],
        'process' => [
            'run' => Yuges\Processable\Actions\RunProcessAction::class,
            'update' => Yuges\Processable\Actions\UpdateProcessAction::class,
            'create' => Yuges\Processable\Actions\CreateProcessAction::class,
        ],
    ],

    'job' => [
        'class' => Yuges\Processable\Jobs\ProcessStageJob::class,
        'handler' => [
            'event' => Yuges\Processable\Handlers\EventHandler::class,
            'stage' => Yuges\Processable\Handlers\StageEventHandler::class,
            'process' => Yuges\Processable\Handlers\ProcessEventHandler::class,
        ],
        'queue' => [
            'name' => env('PROCESS_QUEUE', ''),
            'connection' => env('QUEUE_CONNECTION', 'sync'),
        ],
    ],
];
