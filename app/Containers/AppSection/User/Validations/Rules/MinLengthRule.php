<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Validations\Rules;

final readonly class MinLengthRule extends BaseUserRule
{
    /**
     * @var int $minLength
     */
    private int $minLength;

    /**
     * @param int $minLength
     * @param string $errorMessage
     */
    public function __construct(int $minLength, string $errorMessage)
    {
        $this->minLength = $minLength;
        parent::__construct($errorMessage);
    }

    /**
     * @inheritDoc
     */
    public function isValid(string|int $value, array $context = []): bool
    {
        return strlen($value) >= $this->minLength;
    }
}
