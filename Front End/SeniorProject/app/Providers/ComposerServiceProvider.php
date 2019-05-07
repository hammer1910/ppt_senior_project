<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->boot();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('Home','App\Http\ViewComposers\GroupComposer');
        view()->composer('Home_Master','App\Http\ViewComposers\GroupComposer');
    }
}
