<?php

declare(strict_types=1);


namespace App\Ship\Parents\Values;

final class MissingValue
{

    public function __invoke(): string
    {
        return '';
    }

    public function isMissing(): bool
    {
        return true;
    }

    public function __isset($name): bool
    {
        return false;
    }

    public function isEmpty(): bool
    {
        return true;
    }

    public function __toString(): string
    {
        return '';
    }

    public function toArray(): array
    {
        return [];
    }
}
