<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Validations\Rules;

final readonly class NameRestrictionRule extends BaseUserRule
{
    /**
     * @inheritDoc
     */
    public function isValid(string|int $value, array $context = []): bool
    {
        // Логика проверки имени на плохие слова
        return !in_array(
            $value,
            ['bad-name', 'evil-name']
        );
    }
}
