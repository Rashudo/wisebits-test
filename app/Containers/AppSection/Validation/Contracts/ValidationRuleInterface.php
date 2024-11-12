<?php

namespace App\Containers\AppSection\Validation\Contracts;

interface ValidationRuleInterface
{
    /**
     * @param string|int $value
     * @param array $context
     * @return bool
     */
    public function isValid(string|int $value, array $context = []): bool;

    /**
     * @return string
     */
    public function getErrorMessage(): string;
}
