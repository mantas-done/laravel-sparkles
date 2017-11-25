<?php

namespace MantasDone\LaravelSparkles;

use Illuminate\Support\ServiceProvider;

class SparklesServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        require(base_path('packages/mantas-done/laravel-sparkles/src/Helpers/helpers.php'));
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['command.tinker'];
    }
}
