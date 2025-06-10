<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;  // <-- Add this import

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
 // app/Providers/AppServiceProvider.php

// use Illuminate\Support\Facades\URL;

public function boot()
{
    if (env('APP_ENV') !== 'local') {
        URL::forceScheme('https');
    }
}

}
