<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tests\Unit;

use App\Containers\AppSection\User\Data\Objects\CreateUserDTO;
use App\Containers\AppSection\User\Tasks\CreateUserTask;
use App\Containers\AppSection\User\Tests\TestCase;


final class CreateUserTaskTest extends TestCase
{
    public function testCreateUserTask(): void
    {
        $userDto = new CreateUserDTO(
            name: $this->faker->name,
            email: $this->faker->email,
            notes: $this->faker->text,
        );
        $user = app(CreateUserTask::class)->run($userDto);
        $this->assertModelExists($user);
    }
}
