<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Containers\AppSection\User\Tests\TestCase;


final class FindUserByIdTaskTest extends TestCase
{
    public function testFindUserByIdTask(): void
    {
        $user = User::factory()->create();
        $foundUser = app(FindUserByIdTask::class)->run($user->id);
        self::assertEquals($user->id, $foundUser->id);
    }

    public function testFindUserByIdWithInvalidIdTask(): void
    {
        $this->expectException(UserNotFoundException::class);
        app(FindUserByIdTask::class)->run(999);
    }
}
