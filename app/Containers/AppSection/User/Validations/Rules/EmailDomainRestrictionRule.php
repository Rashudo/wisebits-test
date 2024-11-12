<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Validations\Rules;

final readonly class EmailDomainRestrictionRule extends BaseUserRule
{
    /**
     * @inheritDoc
     */
    public function isValid(string|int $value, array $context = []): bool
    {
        $splittedEmail = explode('@', $value);
        return !in_array(
            $splittedEmail[1] ?? null,
            ['bad-domain.com', 'evil-domain.com']
        );
    }
}
