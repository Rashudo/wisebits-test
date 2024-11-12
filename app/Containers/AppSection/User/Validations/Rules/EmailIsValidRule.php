<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Validations\Rules;

final readonly class EmailIsValidRule extends BaseUserRule
{
    /**
     * @inheritDoc
     */
    public function isValid(string|int $value, array $context = []): bool
    {
        return !!filter_var($value, FILTER_VALIDATE_EMAIL);
    }
}
