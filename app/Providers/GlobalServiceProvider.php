<?php

namespace App\Providers;

use App\Models\Master\Parameter\MasterParameter;
use Illuminate\Support\ServiceProvider;

class GlobalServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('params', function () {
            // Ambil semua data dari masterparameter dan ubah menjadi key-value array
            return MasterParameter::first()->toArray();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
