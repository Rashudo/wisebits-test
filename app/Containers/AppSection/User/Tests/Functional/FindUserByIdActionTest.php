<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Tests\Functional;

use App\Containers\AppSection\User\Actions\FindUserByIdAction;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;

final class FindUserByIdActionTest extends TestCase
{

    public function testFindUserById(): void
    {
        $user = User::factory()->createOne();
        $foundUser = app(FindUserByIdAction::class)->run($user->id);
        self::assertEquals($user->id, $foundUser->id);
    }

    public function testFindNonExistingUser(): void
    {
        $this->expectException(UserNotFoundException::class);
        app(FindUserByIdAction::class)->run(9999);
    }
}
