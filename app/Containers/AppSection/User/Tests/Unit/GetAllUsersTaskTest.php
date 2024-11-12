<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Containers\AppSection\User\Tests\TestCase;


final class GetAllUsersTaskTest extends TestCase
{
    public function testGetAllUsersTask(): void
    {
        User::factory()->count(3)->create();
        $foundUsers = app(GetAllUsersTask::class)->run();
        self::assertCount(3, $foundUsers);
    }

    public function testGetAllUsersWithNoUsersTask(): void
    {
        $foundUsers = app(GetAllUsersTask::class)->run();
        self::assertCount(0, $foundUsers);
    }
}
