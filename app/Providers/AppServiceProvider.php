<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Saat development, jangan diam-diam membuang atribut yang tidak ada
        // di $fillable — lempar error agar bug seperti `stock` hilang terdeteksi.
        Model::preventSilentlyDiscardingAttributes($this->app->isLocal());
    }
}
