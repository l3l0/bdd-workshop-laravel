<?php

namespace App\Providers;

use App\Factory\EloquentProductCreator;
use App\Factory\ProductCreatorInterface;
use App\Repository\EloquentProductCatalogoue;
use App\Repository\ProductCatalogueInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(
            ProductCatalogueInterface::class,
            EloquentProductCatalogoue::class
        );
        $this->app->singleton(
            ProductCreatorInterface::class,
            EloquentProductCreator::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
