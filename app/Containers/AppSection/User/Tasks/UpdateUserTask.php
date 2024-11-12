<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Objects\UpdateUserDTO;
use App\Containers\AppSection\User\Exceptions\UpdateUserFailedException;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

final class UpdateUserTask extends BaseUserTask
{
    /**
     * @param UpdateUserDTO $data
     * @return User
     * @throws UpdateUserFailedException
     */
    public function run(UpdateUserDTO $data): User
    {
        try {
            return $this->repository->update(
                $data->toArray(),
                $data->id
            );
        } catch (ModelNotFoundException $exception) {
            throw new UserNotFoundException(
                previous: $exception
            );
        } catch (Throwable $exception) {
            throw new UpdateUserFailedException(
                previous: $exception
            );
        }
    }
}
