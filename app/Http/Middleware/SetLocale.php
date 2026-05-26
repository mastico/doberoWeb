<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle(Request $request, Closure $next): Response
    {
        $available = array_keys(config('locales.available', []));
        $default = config('locales.default', 'en');

        $first = $request->segment(1);
        $locale = in_array($first, $available, true) ? $first : $default;

        app()->setLocale($locale);

        return $next($request);
    }
}
