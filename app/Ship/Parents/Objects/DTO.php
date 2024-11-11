<?php

declare(strict_types=1);


namespace App\Ship\Parents\Objects;

abstract readonly class DTO
{
    abstract public function toArray(): array;
}
