<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (
            $user &&
            $user->ubah_password === '1' &&
            !$request->routeIs('cms.ubah-password.*')
        ) {
            return redirect()->route('cms.ubah-password.index');
        }

        return $next($request);
    }
}
