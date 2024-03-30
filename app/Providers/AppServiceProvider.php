<?php

namespace App\Providers;

use App\Services\ServiceBase\GetBaseParamsService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', fn ($view) => $view->with('baseParams', app(GetBaseParamsService::class)->execute()) );
    }
}
