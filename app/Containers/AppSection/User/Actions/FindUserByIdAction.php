<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Models\User;
use App\Containers\AppSection\User\Tasks\FindUserByIdTask;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Requests\Request;

final class FindUserByIdAction extends Action
{
    public function run(int $id): User
    {
        return app(FindUserByIdTask::class)->run($id);
    }
}
