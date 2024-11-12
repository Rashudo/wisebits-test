<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Exceptions;

final class UserNotFoundException extends BaseUserFailedException
{
    protected $message = 'Не удалось найти пользователя.';
    protected $code = 404;
}
