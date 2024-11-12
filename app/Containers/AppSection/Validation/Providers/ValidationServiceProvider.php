<?php

declare(strict_types=1);


namespace App\Containers\AppSection\Validation\Providers;

use App\Containers\AppSection\Validation\Contracts\ValidatorInterface;
use App\Containers\AppSection\Validation\Services\Validator;
use Illuminate\Support\ServiceProvider;

final class ValidationServiceProvider extends ServiceProvider
{
    public $bindings = [
        ValidatorInterface::class => Validator::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
