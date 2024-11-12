<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Events;

use App\Ship\Parents\Events\Event;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

abstract class AbstractUserEvent extends Event
{

    public function __construct(
        public Model $model
    )
    {
        //Логика журналирования может быть тут, либо переопределена в дочерних классах
        Log::log('info', $this->model->jsonSerialize());
    }
}
