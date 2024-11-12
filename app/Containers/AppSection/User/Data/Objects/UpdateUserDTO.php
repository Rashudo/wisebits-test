<?php
declare(strict_types=1);


namespace App\Containers\AppSection\User\Data\Objects;

use App\Ship\Parents\Objects\DTO;
use App\Ship\Parents\Values\MissingValue;
use JetBrains\PhpStorm\ArrayShape;

final readonly class UpdateUserDTO extends DTO
{
    /**
     * @param int $id
     * @param string|MissingValue $name
     * @param string|MissingValue $email
     * @param string|MissingValue|null $notes
     */
    public function __construct(
        public int                      $id,
        public string|MissingValue      $name = new MissingValue(),
        public string|MissingValue      $email = new MissingValue(),
        public string|MissingValue|null $notes = new MissingValue(),
    )
    {
    }

    /**
     * @return array<string, string>
     */
    #[ArrayShape(['name' => "string", 'email' => "string", 'notes' => "string|null"])]
    public function toArray(): array
    {
        $return = [];

        if (!$this->name instanceof MissingValue) {
            $return['name'] = $this->name;
        }

        if (!$this->email instanceof MissingValue) {
            $return['email'] = $this->email;
        }

        if (!$this->notes instanceof MissingValue) {
            $return['notes'] = $this->notes;
        }
        return $return;
    }
}
