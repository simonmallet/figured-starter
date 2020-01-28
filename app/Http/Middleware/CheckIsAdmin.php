<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckIsAdmin
{
    public function handle($request, Closure $next)
    {
        if (Auth::user()->role === User::ROLE_ADMIN) {
            return $next($request);
        }
        else {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
    }
}
