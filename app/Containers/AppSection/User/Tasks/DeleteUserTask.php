<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Exceptions\DeleteUserFailedException;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

final class DeleteUserTask extends BaseUserTask
{

    /**
     * @param $id
     * @return bool
     * @throws DeleteUserFailedException|UserNotFoundException
     */
    public function run($id): bool
    {
        try {
            return (bool)$this->repository->delete($id);
        } catch (ModelNotFoundException $exception) {
            throw new UserNotFoundException(
                previous: $exception,
            );
        } catch (Throwable $throwable) {
            throw new DeleteUserFailedException(
                previous: $throwable,
            );
        }
    }
}
