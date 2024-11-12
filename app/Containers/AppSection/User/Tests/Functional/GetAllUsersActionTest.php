<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Tests\Functional;

use App\Containers\AppSection\User\Actions\GetAllUsersAction;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;

final class GetAllUsersActionTest extends TestCase
{

    public function testGetAllUsers(): void
    {
        User::factory()->count(3)->create();
        $foundUsers = app(GetAllUsersAction::class)->run();
        self::assertCount(3, $foundUsers);
    }

    public function testGetAllUsersWithEmptyTable(): void
    {
        $foundUsers = app(GetAllUsersAction::class)->run();
        self::assertCount(0, $foundUsers);
    }
}
