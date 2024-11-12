<?php

declare(strict_types=1);


namespace App\Containers\AppSection\User\Validations\Specifications;

use App\Containers\AppSection\User\Validations\Rules\EmailDomainRestrictionRule;
use App\Containers\AppSection\User\Validations\Rules\EmailIsValidRule;
use App\Containers\AppSection\User\Validations\Rules\EmailUniqueRule;
use App\Containers\AppSection\User\Validations\Rules\LoginAllowedCharactersRule;
use App\Containers\AppSection\User\Validations\Rules\LoginUniqueRule;
use App\Containers\AppSection\User\Validations\Rules\MaxLengthRule;
use App\Containers\AppSection\User\Validations\Rules\MinLengthRule;
use App\Containers\AppSection\User\Validations\Rules\NameRestrictionRule;
use App\Containers\AppSection\Validation\Contracts\SpecificationInterface;

final class CreateUserValidationSpecification implements SpecificationInterface
{
    /**
     * @inheritDoc
     */
    public function getRules(): array
    {
        return [
            'name' => [
                new LoginUniqueRule("Имя пользователя должно быть уникальным"),
                new LoginAllowedCharactersRule("Имя пользователя содержит недопустимые символы"),
                new MinLengthRule(8, "Имя пользователя должно содержать не менее 3 символов"),
                new MaxLengthRule(64, "Имя пользователя должно содержать не более 64 символов"),
                new NameRestrictionRule("Имя пользователя содержит запрещенные слова"),
            ],
            'email' => [
                new EmailIsValidRule("Email должен быть валидным"),
                new EmailUniqueRule("Email должен быть уникальным"),
                new EmailDomainRestrictionRule("Доменное имя для этой почты не разрешено"),
                new MaxLengthRule(256, "Email должен содержать не более 256 символов"),
            ],
        ];
    }
}
