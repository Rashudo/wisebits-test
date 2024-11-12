<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Validations\Rules;

final readonly class MaxLengthRule extends BaseUserRule
{
    /**
     * @var int $maxLength
     */
    private int $maxLength;

    /**
     * @param int $minLength
     * @param string $errorMessage
     */
    public function __construct(int $minLength, string $errorMessage)
    {
        $this->maxLength = $minLength;
        parent::__construct($errorMessage);
    }

    /**
     * @inheritDoc
     */
    public function isValid(string|int $value, array $context = []): bool
    {
        return strlen($value) <= $this->maxLength;
    }
}
