<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class adminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // empty(user()->name) ma win tr ko pyaw tr
        if(!empty(auth()->user())){
            // url()->current() mean current url(route)
            if(url()->current() ==  route('admin#login')  || url()->current() == route('admin#register')){
                return back();
            }
            if(auth()->user()->role != 'admin')
            {
                return back();
            }
        }
        return $next($request);
    }
}
