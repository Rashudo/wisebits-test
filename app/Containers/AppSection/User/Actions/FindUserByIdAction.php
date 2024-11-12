<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;

final class FindUserByIdAction extends Action
{
    /**
     * @param int $id
     *
     * @return User
     * @throws UserNotFoundException
     */
    public function run(int $id): User
    {
        return app(FindUserByIdTask::class)->run($id);
    }
}
