<?php

namespace Caj16\PerencanaanSkpd;

use Illuminate\Support\ServiceProvider;

class PerencanaanSkpdServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Load routes
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');

        // Load migrations
        $this->loadMigrationsFrom(__DIR__ . '/../Migrations');

        // Load views
        $this->loadViewsFrom(__DIR__ . '/../Views', 'surat-masuk');
        $this->publishes([
            __DIR__ . '/../Migrations' => database_path('migrations'),
        ], 'perencanaan-migrations');
    }

    public function register()
    {
        //
    }
}
