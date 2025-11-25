<?php

use Yuges\Package\Enums\KeyType;
use Yuges\Processable\Models\Job;
use Yuges\Processable\Models\Stage;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Enums\StageState;
use Yuges\Package\Database\Schema\Schema;
use Yuges\Package\Database\Schema\Blueprint;
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
            if (Config::getStageKeyHas(true)) {
                $table->key(Config::getStageKeyType(KeyType::BigInteger));
            }

            if (Config::getProcessKeyHas(true)) {
                $table->foreignIdFor(Config::getProcessClass(Process::class))
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->cascadeOnDelete();
            }

            if (Config::getJobKeyHas(true)) {
                $table
                    ->foreignIdFor(Config::getJobClass(Job::class))
                    ->nullable()
                    ->constrained()
                    ->cascadeOnUpdate()
                    ->nullOnDelete();
            }

            $table->string('job_uuid')->nullable();

            $table->string('class');
            $table
                ->unsignedTinyInteger('state')
                ->default(Config::getStageStateClass(StageState::class)::default());

            $table->json('error')->nullable();

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
        });
    }
};
