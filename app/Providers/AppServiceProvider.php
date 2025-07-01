<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    /**
     * @OA\Info(
     *     title="API de Rastreador de entrenamiento",
     *     version="1.0.0"
     * )
     */
    public function register(): void {}

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
