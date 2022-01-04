<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
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
<<<<<<< HEAD
        if (auth()->user()->role == 'admin'){
            return $next($request);
        } elseif (auth()->user()->role == 'user') {
            return $next($request);
        }
        return redirect()->route('index');

=======
        if(Auth::user()->role === 'admin'){
            return $next($request);
        }elseif (Auth::user()->role === 'user') {
            return redirect()->route('index');
        }
>>>>>>> 49480b437b992f1903d8380b4dd926b2aee15ad5
    }
}
