<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Validations\Rules;

use App\Containers\AppSection\User\Criteria\WhereEmailCriteria;
use App\Containers\AppSection\User\Tasks\GetAllUsersTask;

final readonly class EmailUniqueRule extends BaseUserRule
{
    /**
     * @inheritDoc
     */
    public function isValid(string|int $value, array $context = []): bool
    {
        return app(GetAllUsersTask::class)
            ->run(
                collect([
                    new WhereEmailCriteria($value)
                ])
            )
            ->isEmpty();
    }
}
