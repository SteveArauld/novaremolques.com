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
        // Priorité : 1. Session, 2. Cookie, 3. Français par défaut
        if (Session::has('locale')) {
            $locale = Session::get('locale');
        } elseif (Cookie::has('locale')) {
            $locale = Cookie::get('locale');
        } else {
            $locale = 'fr'; // Langue par défaut
        }

        // Vérifier si la langue est autorisée
        $allowedLocales = ['fr', 'en', 'it', 'pt', 'es'];
        if (in_array($locale, $allowedLocales)) {
            App::setLocale($locale);
            Session::put('locale', $locale);
        } else {
            App::setLocale('fr');
            Session::put('locale', 'fr');
        }

        return $next($request);
    }
}