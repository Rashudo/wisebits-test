<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Exceptions;

final class UpdateUserFailedException extends BaseUserFailedException
{
    protected $message = 'Не удалось обновить пользователя.';
    protected $code = 500;
}
