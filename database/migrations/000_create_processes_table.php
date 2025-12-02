<?php

use Yuges\Package\Enums\KeyType;
use Yuges\Processable\Config\Config;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Enums\ProcessState;
use Yuges\Package\Database\Schema\Schema;
use Yuges\Package\Database\Schema\Blueprint;
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
            if (Config::getProcessKeyHas(true)) {
                $table->key(Config::getProcessKeyType(KeyType::BigInteger));
            }

            $table->string('class');
            $table->longText('payload')->nullable();
            $table
                ->unsignedTinyInteger('state')
                ->default(Config::getProcessStateClass(ProcessState::class)::default());

            if (Config::getProcessableKeyHas(true)) {
                $table->keyMorphs(
                    Config::getProcessableKeyType(KeyType::BigInteger),
                    Config::getProcessableRelationName('processable')
                );
            }

            $table->timestamp('started_at')->nullable();
            $table->timestamp('finished_at')->nullable();
            $table->timestamp('failed_at')->nullable();
            $table->timestamps();
        });
    }
};
