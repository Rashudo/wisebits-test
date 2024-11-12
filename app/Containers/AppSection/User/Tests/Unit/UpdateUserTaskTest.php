<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Data\Objects\UpdateUserDTO;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\Tests\TestCase;


final class UpdateUserTaskTest extends TestCase
{
    public function testUpdateUserTask(): void
    {
        $user = User::factory()->create();

        $updateDto = new UpdateUserDTO(
            id: $user->id,
            name: 'new name',
            email: 'new@email.com',
            notes: 'new notes',
        );

        $newUser = app(UpdateUserTask::class)->run($updateDto);

        self::assertEquals($updateDto->name, $newUser->name);
        self::assertEquals($updateDto->email, $newUser->email);
        self::assertEquals($updateDto->notes, $newUser->notes);
    }

    public function testUpdateUserFailedTask(): void
    {
        $this->expectException(UserNotFoundException::class);

        $updateDto = new UpdateUserDTO(
            id: 777,
            name: 'new name',
            email: '',
            notes: 'new notes',
        );

        app(UpdateUserTask::class)->run($updateDto);
    }
}
