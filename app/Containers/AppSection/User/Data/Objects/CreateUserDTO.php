<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Data\Objects;

use App\Ship\Parents\Objects\DTO;
use JetBrains\PhpStorm\ArrayShape;

final readonly class CreateUserDTO extends DTO
{
    /**
     * @param string $name
     * @param string $email
     * @param string|null $notes
     */
    public function __construct(
        public string      $name,
        public string      $email,
        public string|null $notes,
    )
    {
    }

    /**
     * @param array $array<string, string|null>
     * @return self
     */
    public static function createFromArray(array $array): self
    {
        return new self(
            name: $array['name'],
            email: $array['email'],
            notes: $array['notes'],
        );
    }

    /**
     * @return array<string, string>
     */
    #[ArrayShape(['name' => "string", 'email' => "string", 'notes' => "string|null"])]
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'notes' => $this->notes,
        ];
    }
}
