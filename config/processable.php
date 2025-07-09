<?php

// Config for yuges/processable

return [
    /*
     * FQCN (Fully Qualified Class Name) of the models to use for process
     */
    'models' => [
        'process' => [
            'key' => Yuges\Package\Enums\KeyType::BigInteger,
            'table' => 'processes',
            'class' => Yuges\Processable\Models\Process::class,
            'observer' => Yuges\Processable\Observers\ProcessObserver::class,
        ],
        'stage' => [
            'key' => Yuges\Package\Enums\KeyType::BigInteger,
            'table' => 'process_stages',
            'class' => Yuges\Processable\Models\Stage::class,
            'observer' => Yuges\Processable\Observers\StageObserver::class,
        ],
        'processable' => [
            'key' => Yuges\Package\Enums\KeyType::BigInteger,
            'allowed' => [
                'classes' => [
                    \App\Models\User::class,
                ],
            ],
            'relation' => [
                'name' => 'processable',
            ],
            'observer' => Yuges\Processable\Observers\ProcessableObserver::class,
        ],
    ],
];
