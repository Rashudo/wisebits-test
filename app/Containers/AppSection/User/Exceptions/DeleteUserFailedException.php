<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Exceptions;

final class DeleteUserFailedException extends BaseUserFailedException
{
    protected $message = 'Не удалось удалить пользователя.';
    protected $code = 500;
}
