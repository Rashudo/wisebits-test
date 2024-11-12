<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Tests\Functional;

use App\Containers\AppSection\User\Actions\CreateUserAction;
use App\Containers\AppSection\User\Data\Objects\CreateUserDTO;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tests\TestCase;
use App\Containers\AppSection\Validation\Exceptions\ValidationException;

final class CreateUserActionTest extends TestCase
{

    public function testCreateUserAction(): void
    {
        $userDto = new CreateUserDTO(
            name: strtolower($this->faker->lexify(str_repeat('?', 8))),
            email: $this->faker->email,
            notes: $this->faker->text,
        );
        $user = app(CreateUserAction::class)->run($userDto);
        $this->assertModelExists($user);
    }

    public function testWrongProhibitedEmailDomain(): void
    {
        $this->expectException(ValidationException::class);
        $userDto = new CreateUserDTO(
            name: strtolower($this->faker->lexify(str_repeat('?', 8))),
            email: 'whatever@bad-domain.com',
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);
        $this->assertDatabaseCount('users', 0);
    }

    public function testEmailUnique(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();
        $userDto = new CreateUserDTO(
            name: strtolower($this->faker->lexify(str_repeat('?', 8))),
            email: $user->email,
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);
        $this->assertDatabaseCount('users', 0);
    }

    public function testNameDoesntContainWrongSymbols(): void
    {
        $this->expectException(ValidationException::class);
        $userDto = new CreateUserDTO(
            name: 'Name with wrong symbols #',
            email: $this->faker->email,
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);

        $this->assertDatabaseCount('users', 0);
    }

    public function testNameIsNotEmpty(): void
    {
        $this->expectException(ValidationException::class);
        $userDto = new CreateUserDTO(
            name: '',
            email: $this->faker->email,
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);

        $this->assertDatabaseCount('users', 0);
    }

    public function testNameIsUnique(): void
    {
        $this->expectException(ValidationException::class);
        $user = User::factory()->create();
        $userDto = new CreateUserDTO(
            name: $user->name,
            email: $this->faker->email,
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);

        $this->assertDatabaseCount('users', 0);
    }

    public function testNameIsNotLongerThan64Symbols(): void
    {
        $this->expectException(ValidationException::class);
        $userDto = new CreateUserDTO(
            name: $this->faker->lexify(str_repeat('?', 65)),
            email: $this->faker->email,
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);

        $this->assertDatabaseCount('users', 0);
    }

    public function testEmailIsNotLongerThan256Symbols(): void
    {
        $this->expectException(ValidationException::class);
        $userDto = new CreateUserDTO(
            name: strtolower($this->faker->lexify(str_repeat('?', 8))),
            email: $this->faker->lexify(str_repeat('?', 245)) . '@example.com',
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);

        $this->assertDatabaseCount('users', 0);
    }

    public function testNameContainsBadWords(): void
    {
        $this->expectException(ValidationException::class);
        $userDto = new CreateUserDTO(
            name: 'evil-name',
            email: $this->faker->email,
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);

        $this->assertDatabaseCount('users', 0);
    }

    public function testEmailIsValid(): void
    {
        $this->expectException(ValidationException::class);
        $userDto = new CreateUserDTO(
            name: strtolower($this->faker->lexify(str_repeat('?', 8))),
            email: 'invalid-email',
            notes: $this->faker->text
        );
        app(CreateUserAction::class)->run($userDto);

        $this->assertDatabaseCount('users', 0);
    }
}
