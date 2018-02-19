<?php
namespace AngelOD\LaravelListDb;

use Illuminate\Support\ServiceProvider;

class ListDbServiceProvider extends ServiceProvider {

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->commands(
            \AngelOD\LaravelListDb\Commands\ListDbModel::class,
            \AngelOD\LaravelListDb\Commands\ListDbTable::class,
            \AngelOD\LaravelListDb\Commands\ListDbTables::class
        );
    }

}