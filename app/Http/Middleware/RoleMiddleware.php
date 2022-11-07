<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Auth\LoginController;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role != 1) {
            Auth::logout();

            return redirect()->route('get-login')->with('error', 'Access denied!');
        }

        return $next($request);
    }
}
