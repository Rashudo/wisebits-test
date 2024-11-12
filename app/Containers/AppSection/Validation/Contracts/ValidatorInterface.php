<?php

namespace App\Containers\AppSection\Validation\Contracts;

interface ValidatorInterface
{
    /**
     * @param object $dto
     * @param array $rules <array-key, array<App\Containers\AppSection\Validation\Contracts\ValidationInterface>>
     * @return bool
     */
    public function validate(object $dto, array $rules): bool;

    /**
     * @return array<string, string>
     */
    public function getErrors(): array;
}
