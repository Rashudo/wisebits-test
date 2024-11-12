<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Data\Objects\UpdateUserDTO;
use App\Containers\AppSection\User\Exceptions\UpdateUserFailedException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\UpdateUserTask;
use App\Containers\AppSection\User\Validations\Specifications\UpdateUserValidationSpecification;
use App\Containers\AppSection\Validation\Contracts\ValidatorInterface;
use App\Containers\AppSection\Validation\Exceptions\ValidationException;
use App\Ship\Parents\Actions\Action;

final class UpdateUserAction extends Action
{
    /**
     * @param ValidatorInterface $validator
     * @param UpdateUserValidationSpecification $updateUserSpecification
     * @param UpdateUserTask $updateUserTask
     */
    public function __construct(
        private readonly ValidatorInterface                $validator,
        private readonly UpdateUserValidationSpecification $updateUserSpecification,
        private readonly UpdateUserTask                    $updateUserTask,
    )
    {
    }

    /**
     * @param UpdateUserDTO $updateUserDTO
     * @return User
     * @throws ValidationException
     * @throws UpdateUserFailedException
     */
    public function run(UpdateUserDTO $updateUserDTO): User
    {
        if (
            !$this->validator->validate(
                $updateUserDTO,
                $this->updateUserSpecification->getRules()
            )
        ) {
            throw new ValidationException($this->validator->getErrors());
        }
        return $this->updateUserTask->run($updateUserDTO);
    }
}
