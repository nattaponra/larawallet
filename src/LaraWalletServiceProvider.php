<?php

namespace nattaponra\LaraWallet;

use Illuminate\Support\ServiceProvider;

class LaraWalletServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');

        $this->publishes([__DIR__.'/config/config.php' => config_path('larawallet.php'),]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
