<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use Throwable;

final class FindUserByIdTask extends BaseUserTask
{

    /**
     * @param int $id
     * @return User
     * @throws UserNotFoundException
     */
    public function run(int $id): User
    {
        try {
            return $this->repository->find($id);
        } catch (Throwable $throwable) {
            throw new UserNotFoundException(
                previous: $throwable,
            );
        }
    }
}
