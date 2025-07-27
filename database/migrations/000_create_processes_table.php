<?php

use Yuges\Package\Enums\KeyType;
use Yuges\Processable\Models\Batch;
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
        $this->table = Config::getProcessClass(Process::class)::getTableName();
    }

    public function up(): void
    {
        if (Schema::hasTable($this->table)) {
            return;
        }

        Schema::create($this->table, function (Blueprint $table) {
            $table->key(Config::getProcessKeyType(KeyType::BigInteger));

            $table->string('class');
            $table->longText('payload')->nullable();
            $table->unsignedTinyInteger('state')->default(ProcessStatesEnum::PENDING);

            $table->keyMorphs(
                Config::getProcessableKeyType(KeyType::BigInteger),
                Config::getProcessableRelationName('processable')
            );

            $table->string(Config::getBatch(Batch::class)->getForeignKey())->nullable();
            $table
                ->foreign(Config::getBatch(Batch::class)->getForeignKey())
                ->references('id')
                ->on(Config::getBatchClass(Batch::class)::getTableName())
                ->cascadeOnUpdate()
                ->nullOnDelete();

            $table->timestamp('reserved_at')->nullable();
            $table->timestamp('available_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
        });
    }
};
