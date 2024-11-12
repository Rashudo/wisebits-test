<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Data\Objects\CreateUserDTO;
use App\Containers\AppSection\User\Data\Objects\UpdateUserDTO;
use App\Containers\AppSection\User\Events\CreatedUserEvent;
use App\Containers\AppSection\User\Events\DeletedUserEvent;
use App\Containers\AppSection\User\Events\UpdatedUserEvent;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserTask;
use App\Containers\AppSection\User\Tasks\DeleteUserTask;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\Tests\TestCase;
use Illuminate\Support\Facades\Event;

final class UserEventsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        Event::fake(); // Фейкуем все события
    }

    public function testCreatedUserEvent(): void
    {
        $userDto = new CreateUserDTO(
            name: $this->faker->name,
            email: $this->faker->email,
            notes: $this->faker->text,
        );
        app(CreateUserTask::class)->run($userDto);
        Event::assertDispatched(CreatedUserEvent::class);
    }

    public function testDeletedUserEvent(): void
    {
        $user = User::factory()->create();
        app(DeleteUserTask::class)->run($user->id);
        Event::assertDispatched(DeletedUserEvent::class);
    }

    public function testUpdatedUserEvent(): void
    {
        $user = User::factory()->create();
        $updateDto = new UpdateUserDTO(
            id: $user->id,
            name: $this->faker->name,
            email: $this->faker->email,
            notes: $this->faker->text,
        );
        app(UpdateUserTask::class)->run($updateDto);
        Event::assertDispatched(UpdatedUserEvent::class);
    }
}
