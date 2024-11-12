<?php

namespace App\Containers\AppSection\Validation\Contracts;

interface SpecificationInterface
{
    /**
     * @return array<array-key, array<array-key, ValidationRuleInterface>>
     */
    public function getRules(): array;
}
