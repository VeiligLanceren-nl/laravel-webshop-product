<?php

namespace Tests;

use Illuminate\Support\InteractsWithTime;
use Orchestra\Testbench\TestCase as BaseTestCase;
use VeiligLanceren\LaravelWebshopProduct\ProductServiceProvider;

class TestCase extends BaseTestCase
{
    use InteractsWithTime;

    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @param $app
     * @return string[]
     */
    protected function getPackageProviders($app): array
    {
        return [
            ProductServiceProvider::class,
        ];
    }

    /**
     * @return void
     */
    protected function defineDatabaseMigrations(): void
    {
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }
}