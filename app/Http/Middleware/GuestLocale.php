<?php

namespace App\Http\Middleware;

use Closure;

class GuestLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(request()->cookie('guestLang')) {
            app()->setLocale(request()->cookie('guestLang'));

            return $next($request);
        }
        $browserLang = substr(request()->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);
        app()->setLocale($browserLang);

        $response = $next($request);
        return $response->withCookie(cookie()->forever('guestLang', $browserLang));
    }
}
