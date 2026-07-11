<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public const LOCALES = ['en', 'vi'];

    public function handle(Request $request, Closure $next): Response
    {
        // Trang admin (Filament) giữ nguyên locale mặc định.
        if (! $request->is('admin*')) {
            $locale = $request->session()->get('locale', config('app.locale'));

            if (in_array($locale, self::LOCALES, true)) {
                app()->setLocale($locale);
            }
        }

        return $next($request);
    }
}
