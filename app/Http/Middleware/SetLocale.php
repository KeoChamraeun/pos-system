<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        if (Session::has('locale')) {
            App::setLocale(Session::get('locale'));
        } else {
            // Default language if none set
            Session::put('locale', config('app.locale'));
            App::setLocale(config('app.locale'));
        }

        return $next($request);
    }
}
