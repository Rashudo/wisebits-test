<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Actions;

use App\Containers\AppSection\User\Tasks\GetAllUsersTask;
use App\Ship\Parents\Actions\Action;
use Traversable;

final class GetAllUsersAction extends Action
{
    /**
     * @return Traversable
     */
    public function run(): Traversable
    {
        // Тут можно добавить логику Критериев (Criteria) для фильрации данных
        return app(GetAllUsersTask::class)->run();
    }
}
