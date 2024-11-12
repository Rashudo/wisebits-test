<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Tasks;

use App\Containers\AppSection\User\Data\Repositories\UserRepository;
use App\Ship\Parents\Tasks\Task;

abstract class BaseUserTask extends Task
{
    /**
     * @param UserRepository $repository
     */
    public function __construct(
        protected UserRepository $repository
    )
    {
    }
}
