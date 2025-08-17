<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        if (Auth::check() && Auth::user()->role == 'U') {
            return redirect()->route('home');
        } else if (Auth::check() && Auth::user()->role = 'A') {
            return redirect()->route('admin_dashboard');
        }

        return $next($request);
    }
}
