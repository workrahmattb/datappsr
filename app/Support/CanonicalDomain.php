<?php

namespace App\Support;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CanonicalDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $base = rtrim(config('seo.url'), '/');
        $host = parse_url($base, PHP_URL_HOST);
        $scheme = parse_url($base, PHP_URL_SCHEME);

        if (config('seo.redirect_domain') && in_array($request->getHost(), [$host, 'www.'.$host], true)
            && ($request->getHost() !== $host || $request->getScheme() !== $scheme)) {
            return redirect()->away($base.$request->getRequestUri(), $request->isMethodSafe() ? 301 : 308);
        }

        return $next($request);
    }
}
