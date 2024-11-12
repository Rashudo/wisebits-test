<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Tests\Functional;

use App\Containers\AppSection\User\Actions\DeleteUserAction;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;

final class DeleteUserActionTest extends TestCase
{

    public function testDeleteUser(): void
    {
        $user = User::factory()->createOne();
        app(DeleteUserAction::class)->run($user->id);
        $this->assertSoftDeleted($user);
    }

    public function testDeleteNonExistingUser(): void
    {
        $this->expectException(UserNotFoundException::class);
        app(DeleteUserAction::class)->run(9999);
    }
}
