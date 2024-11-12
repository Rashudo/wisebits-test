<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Tests\Functional;

use App\Containers\AppSection\User\Actions\GetAllUsersAction;
use App\Containers\AppSection\User\Actions\UpdateUserAction;
use App\Containers\AppSection\User\Criteria\WhereEmailCriteria;
use App\Containers\AppSection\User\Criteria\WhereNameCriteria;
use App\Containers\AppSection\User\Data\Objects\UpdateUserDTO;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;
use App\Containers\AppSection\Validation\Exceptions\ValidationException;

final class UpdateUserActionTest extends TestCase
{
    public function testUpdateUser(): void
    {
        $user = User::factory()->create();

        $updateDto = new UpdateUserDTO(
            id: $user->id,
            name: 'newname777',
            email: 'new@email.com',
        );
        app(UpdateUserAction::class)->run(
            $updateDto
        );
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $updateDto->name,
            'email' => $updateDto->email,
        ]);
        $this->assertDatabaseMissing('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testUpdateUserOnlyName()
    {
        $user = User::factory()->create();
        $updateDto = new UpdateUserDTO(
            id: $user->id,
            name: 'newname777',
        );
        app(UpdateUserAction::class)->run($updateDto);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $updateDto->name,
            'email' => $user->email,
        ]);
    }

    public function testUpdateUserOnlyEmail()
    {
        $user = User::factory()->create();
        $updateDto = new UpdateUserDTO(
            id: $user->id,
            email: 'new@email.com',
        );
        app(UpdateUserAction::class)->run($updateDto);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $updateDto->email,
        ]);
    }

    public function testUserUpdateOnlyNote()
    {
        $user = User::factory()->create();
        $updateDto = new UpdateUserDTO(
            id: $user->id,
            notes: 'new notes',
        );
        app(UpdateUserAction::class)->run($updateDto);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'notes' => $updateDto->notes,
        ]);
    }

    public function testUpdateUserWithEmptyData(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();

        $updateDto = new UpdateUserDTO(
            id: $user->id,
            name: '',
            email: '',
        );
        app(UpdateUserAction::class)->run(
            $updateDto
        );
    }

    public function testUpdateUserWithInvalidEmail(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();

        $updateDto = new UpdateUserDTO(
            id: $user->id,
            name: 'newname777',
            email: 'invalidemail',
        );
        app(UpdateUserAction::class)->run(
            $updateDto
        );
    }

    public function testUpdateUserWithInvalidId(): void
    {
        $this->expectException(UserNotFoundException::class);
        User::factory()->create();

        $updateDto = new UpdateUserDTO(
            id: 999,
            name: 'newname777',
            email: 'new@email.com'
        );
        app(UpdateUserAction::class)->run(
            $updateDto
        );
    }

    public function testUpdateUserWithProhibitedEmailDomain(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();
        $updateDto = new UpdateUserDTO(
            id: $user->id,
            email: 'whatever@bad-domain.com',
        );
        app(UpdateUserAction::class)->run($updateDto);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testUpdateUserEmailUnique(): void
    {
        $this->expectException(ValidationException::class);
        $someUser = User::factory()->create();
        $user = User::factory()->create();
        $userDto = new UpdateUserDTO(
            id: $user->id,
            name: $user->name,
            email: $someUser->email,
            notes: $this->faker->text
        );
        app(UpdateUserAction::class)->run($userDto);
        $usersWithOldEmail = app(GetAllUsersAction::class)->run(
            collect([new WhereEmailCriteria($someUser->email)])
        );
        $this->assertCount(1, $usersWithOldEmail);
    }

    public function testUpdateUserNameDoesntContainWrongSymbols(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();
        $userDto = new UpdateUserDTO(
            id: $user->id,
            name: 'Name with wrong symbols #',
        );
        app(UpdateUserAction::class)->run($userDto);
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testNameIsUnique(): void
    {
        $this->expectException(ValidationException::class);
        $someUser = User::factory()->create();
        $user = User::factory()->create();
        $userDto = new UpdateUserDTO(
            id: $user->id,
            name: $someUser->name,
        );
        app(UpdateUserAction::class)->run($userDto);

        $foundUsers = app(GetAllUsersAction::class)->run(
            collect([new WhereNameCriteria($someUser->name)])
        );
        $this->assertCount(1, $foundUsers);
    }

    public function testUpdateUserNameIsNotLongerThan64Symbols(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();
        $userDto = new UpdateUserDTO(
            id: $user->id,
            name: $this->faker->lexify(str_repeat('?', 65)),
        );
        app(UpdateUserAction::class)->run($userDto);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }


    public function testUpdateUserEmailIsNotLongerThan256Symbols(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();
        $userDto = new UpdateUserDTO(
            id: $user->id,
            email: $this->faker->lexify(str_repeat('?', 245)) . '@example.com',
        );
        app(UpdateUserAction::class)->run($userDto);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testUpdateUserNameContainsBadWords(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();
        $userDto = new UpdateUserDTO(
            id: $user->id,
            name: 'evil-name',
        );
        app(UpdateUserAction::class)->run($userDto);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function testEmailIsValid(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();
        $userDto = new UpdateUserDTO(
            id: $user->id,
            email: 'invalid-email',
        );
        app(UpdateUserAction::class)->run($userDto);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }
}
