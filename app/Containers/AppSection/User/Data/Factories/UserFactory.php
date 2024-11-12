<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Factories;

use App\Containers\AppSection\User\Models\User;
use App\Ship\Parents\Factories\Factory;
use JetBrains\PhpStorm\ArrayShape;

final class UserFactory extends Factory
{
    protected $model = User::class;

    /**
     * @return array<string, mixed>
     */
    #[ArrayShape(['name' => "string", 'email' => "string", 'notes' => "string"])]
    public function definition(): array
    {
        return [
            'name' => strtolower($this->faker->lexify(str_repeat('?', 8))),
            'email' => $this->faker->unique()->safeEmail,
            'notes' => $this->faker->text,
        ];
    }
}
