<?php

declare(strict_types=1);


namespace App\Containers\AppSection\Validation\Exceptions;

use App\Ship\Parents\Exceptions\Exception;

final class ValidationException extends Exception
{

    protected array $errors;

    /**
     * @param array $errors <string>
     */
    public function __construct(array $errors)
    {
        $this->errors = $errors;
        $message = 'Validation failed. Errors: ' . json_encode($errors);
        parent::__construct($message);
    }

    /**
     * @return array<string>
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
