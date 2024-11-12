<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Validations\Rules;

use App\Containers\AppSection\Validation\Contracts\ValidationRuleInterface;

abstract readonly class BaseUserRule implements ValidationRuleInterface
{
    /**
     * @param string $errorMessage
     */
    public function __construct(
        private string $errorMessage
    )
    {
    }

    /**
     * @inheritDoc
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * @inheritDoc
     */
    abstract public function isValid(string|int $value, array $context = []): bool;
}
