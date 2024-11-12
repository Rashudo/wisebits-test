<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Data\Objects\CreateUserDTO;
use App\Containers\AppSection\User\Exceptions\CreateUserFailedException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\CreateUserTask;
use App\Containers\AppSection\User\Validations\Specifications\CreateUserValidationSpecification;
use App\Containers\AppSection\Validation\Contracts\ValidatorInterface;
use App\Containers\AppSection\Validation\Exceptions\ValidationException;

final class CreateUserAction extends BaseUserAction
{
    /**
     * @param ValidatorInterface $validator
     * @param CreateUserValidationSpecification $createUserSpecification
     * @param CreateUserTask $createUserTask
     */
    public function __construct(
        private readonly ValidatorInterface                $validator,
        private readonly CreateUserValidationSpecification $createUserSpecification,
        private readonly CreateUserTask                    $createUserTask,
    )
    {
    }

    /**
     * @param CreateUserDTO $createUserDTO
     * @return User
     * @throws CreateUserFailedException|ValidationException
     */
    public function run(CreateUserDTO $createUserDTO): User
    {
        if (
            !$this->validator->validate(
                $createUserDTO,
                $this->createUserSpecification->getRules()
            )
        ) {
            throw new ValidationException($this->validator->getErrors());
        }
        return $this->createUserTask->run($createUserDTO);
    }
}
