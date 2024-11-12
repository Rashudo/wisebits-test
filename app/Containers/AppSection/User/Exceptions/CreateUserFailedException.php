<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Exceptions;

final class CreateUserFailedException extends BaseUserFailedException
{
    protected $message = 'Не удалось создать пользователя.';
    protected $code = 500;
}
