<?php

namespace App\Http\Middleware;

use Auth;
use Closure;
use DB;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckoutRedirect
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $cart_items = DB::table('cart')->where('cart_session_id', session()->get('cart_session_id'))->get();

        if ($cart_items->isNotEmpty()) {
            if (Auth::check()) {
                if (Auth::user()->role == 'U') {
                    return $next($request);
                } else {
                    session()->flush();
                    return redirect()->route('admin_dashboard');
                }
            } else {
                if((url()->previous() == route('cartpage') && (url()->current() == route('checkout')))) {
                    if (!session()->has('url.intended')) {
                        session(['url.intended' => route('checkout')]); // Save the checkout page's url in session
                    }
                }

                return redirect()->route('login');
            }
        } else {
            return redirect()->route('shop');
        }
    }
}
