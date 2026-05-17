<?php
// app/Http/Middleware/LanguageMiddleware.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cookie;

class LanguageMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } elseif (Cookie::has('locale')) {
            $locale = Cookie::get('locale');
        } else {
            $locale = 'pt'; 
        }

        $allowedLocales = ['fr', 'pt', 'es'];
        if (in_array($locale, $allowedLocales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            App::setLocale('pt');
            Session::put('locale', 'pt');
        }

        return $next($request);
    }
}