<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class SetLocale
{
    protected array $supported = ['pt_BR', 'en', 'es'];

    public function handle(Request $request, Closure $next): mixed
    {
        $locale = Session::get('locale');

        if ($locale && in_array($locale, $this->supported, true)) {
            App::setLocale($locale);
        }

        return $next($request);
    }
}
