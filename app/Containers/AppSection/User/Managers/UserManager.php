<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Managers;

use App\Containers\AppSection\User\Actions\CreateUserAction;
use App\Containers\AppSection\User\Actions\FindUserByIdAction;
use App\Containers\AppSection\User\Data\Objects\CreateUserDTO;
use App\Containers\AppSection\User\Exceptions\UserNotFoundException;
use App\Containers\AppSection\User\Models\User;

/**
 * Class UserManager
 * @package App\Containers\AppSection\User\Managers
 *
 * Менеджер для работы с контейнером User.
 * Фасад для работы с методами контейнера User извне.
 */
final class UserManager
{
    /**
     * @param array $data
     * @return User
     */
    public static function createUser(array $data): User
    {
        $createUserDto = CreateUserDTO::createFromArray($data);
        return app(CreateUserAction::class)->run($createUserDto);
    }

    /**
     * @param int $id
     * @return User
     *
     * @throws UserNotFoundException
     */
    public static function findUserById(int $id): User
    {
        return app(FindUserByIdAction::class)->run($id);
    }

    // Другие методы для работы с контейнером User извне
}
