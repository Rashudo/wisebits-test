<?php

declare(strict_types=1);


namespace App\Containers\AppSection\Validation\Services;

use App\Containers\AppSection\Validation\Contracts\ValidatorInterface;
use App\Ship\Parents\Values\MissingValue;
use JetBrains\PhpStorm\ArrayShape;

final class Validator implements ValidatorInterface
{
    private array $errors = [];

    /**
     * @inheritDoc
     */
    public function validate(
        object $dto,
        array  $rules
    ): bool
    {
        $noErrors = true;
        foreach ($rules as $field => $fieldRules) {
            if (
                !property_exists($dto, $field)
                || $dto->$field instanceof MissingValue
            ) {
                continue;
            }
            foreach ($fieldRules as $rule) {
                if (!$rule->isValid($dto->$field)) {
                    $this->errors[$field][] = $rule->getErrorMessage();
                    $noErrors = false;
                }
            }
        }
        return $noErrors;
    }

    /**
     * @inheritDoc
     */
    #[ArrayShape(['field' => "string"])]
    public function getErrors(): array
    {
        return $this->errors;
    }
}
