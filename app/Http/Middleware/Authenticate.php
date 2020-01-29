<?php

namespace App\Http\Middleware;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    const AUTH_ERROR = 'authentication_error';

    public function handle($request, Closure $next, ...$guards)
    {
        if ($this->authenticate($request, $guards) === self::AUTH_ERROR) {
            return response()->json([
                'error' => 'Unauthorized'
            ], 403);
        }
        return $next($request);
    }

    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }
        foreach ($guards as $guard) {
            if ($this->auth->guard($guard)->check()) {
                return $this->auth->shouldUse($guard);
            }
        }
        return self::AUTH_ERROR;
    }
}
