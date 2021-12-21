<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
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
        // $user = User::find($userId);
        // if ($request->user()->role == 'admin'){
        //     return redirect('/admin/import/users');
        // } else {
        //     return redirect('/');
        // }
        // return $next($request);

        if (Auth::user() &&  Auth::user()->admin == 1) {
            return $next($request);
        }

        return redirect('/');
    }
}
