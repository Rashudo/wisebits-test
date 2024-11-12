<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Objects\CreateUserDTO;
use App\Containers\AppSection\User\Exceptions\CreateUserFailedException;
use App\Containers\AppSection\User\Models\User;
use Throwable;

final class CreateUserTask extends BaseUserTask
{
    /**
     * @param CreateUserDTO $createUserDTO
     * @return User
     * @throws CreateUserFailedException
     */
    public function run(CreateUserDTO $createUserDTO): User
    {
        try {
            return $this->repository->create(
                $createUserDTO->toArray()
            );
        } catch (Throwable $throwable) {
            throw new CreateUserFailedException(
                previous: $throwable,
            );
        }
    }
}
