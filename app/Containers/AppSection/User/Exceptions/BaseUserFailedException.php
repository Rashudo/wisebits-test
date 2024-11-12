<?php
declare(strict_types=1);

namespace App\Containers\AppSection\User\Exceptions;


use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Support\Facades\Log;

abstract class BaseUserFailedException extends Exception
{
    public function __construct(
        protected $previous,
    )
    {
        // Тут можно добавить логику логирования ошибок пользователя
        Log::error($this->message);
        parent::__construct(
            message: $this->message,
            code: $this->code,
            previous: $this->previous,
        );
    }
}
