<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\DeleteUserTask;
use App\Ship\Parents\Actions\Action;

final class DeleteUserAction extends Action
{
    public function run(int $id): void
    {
        app(DeleteUserTask::class)->run($id);
    }
}
