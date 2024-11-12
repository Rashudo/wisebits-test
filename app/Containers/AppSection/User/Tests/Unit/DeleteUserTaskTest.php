<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\DeleteUserTask;
use App\Containers\AppSection\User\Tests\TestCase;


final class DeleteUserTaskTest extends TestCase
{
    public function testDeleteUserTask(): void
    {
        $user = User::factory()->create();
        app(DeleteUserTask::class)->run($user->id);
        $this->assertSoftDeleted($user);
    }

    public function testDeleteUserFailedTask(): void
    {
        $this->expectException(UserNotFoundException::class);
        app(DeleteUserTask::class)->run(0);
    }
}
