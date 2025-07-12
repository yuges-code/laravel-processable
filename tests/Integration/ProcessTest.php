<?php

namespace Yuges\Processable\Tests\Integration;

use Yuges\Processable\Config\Config;
use Yuges\Processable\Tests\TestCase;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Tests\Stubs\Models\Post;

class ProcessTest extends TestCase
{
    public function testProcessPost()
    {
        $post = Post::query()->create([
            'title' => 'New post',
        ]);

        $this->assertDatabaseHas(Post::getTableName('posts'), [
            'id' => $post->id,
            'title' => 'New post',
        ]);

        // $process = Process::query()->create([
        //     'name' => 'programming',
        // ]);
    }
}
