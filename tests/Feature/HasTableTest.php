<?php

namespace Yuges\Processable\Tests\Feature;

use Yuges\Processable\Models\Stage;
use Yuges\Processable\Tests\TestCase;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Tests\Stubs\Models\User;

class HasTableTest extends TestCase
{
    public function testGettingTableName()
    {
        $this->assertEquals('users', User::getTableName());
        $this->assertEquals('processes', Process::getTableName());
        $this->assertEquals('process_stages', Stage::getTableName());
    }
}
