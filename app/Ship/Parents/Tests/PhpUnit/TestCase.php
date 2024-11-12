<?php

namespace App\Ship\Parents\Tests\PhpUnit;

use Faker\Generator;
use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as LaravelTestCase;

abstract class TestCase extends LaravelTestCase
{
    use RefreshDatabase;

    protected Generator $faker;

    public function createApplication()
    {
        $app = require Application::inferBasePath() . '/bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        $this->faker = $app->make(Generator::class);

        return $app;
    }
}
