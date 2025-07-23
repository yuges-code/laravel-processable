<?php

use Yuges\Package\Enums\KeyType;
use Yuges\Processable\Models\Job;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Package\Database\Schema\Schema;
use Yuges\Package\Database\Schema\Blueprint;
use Yuges\Processable\Enums\ProcessStatesEnum;
use Yuges\Package\Database\Migrations\Migration;

return new class extends Migration
{
    public function __construct()
    {
        $this->table = Config::getStageClass(Stage::class)::getTableName();
    }

    public function up(): void
    {
        if (Schema::hasTable($this->table)) {
            return;
        }

        Schema::create($this->table, function (Blueprint $table) {
            $table->key(Config::getStageKeyType(KeyType::BigInteger));

            $table->foreignIdFor(Config::getProcessClass(Process::class))
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table
                ->foreignIdFor(Config::getJobClass(Job::class))
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->string('class');
            $table->unsignedTinyInteger('state')->default(ProcessStatesEnum::PENDING);

            $table->timestamps();
        });
    }
};
