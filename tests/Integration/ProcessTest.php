<?php

namespace Yuges\Processable\Tests\Integration;

use Yuges\Processable\Models\Stage;
use Yuges\Processable\Models\Process;
use Yuges\Processable\Tests\TestCase;
use Yuges\Processable\Tests\Stubs\Models\Post;
use Yuges\Processable\Tests\Stubs\Processes\TestProcess;

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

        $process = $post->process(TestProcess::class);

        $process->retry();
    }
}
