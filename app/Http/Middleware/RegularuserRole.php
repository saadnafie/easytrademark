<?php

namespace App\Http\Middleware;

use Closure;

class RegularuserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if(auth()->check()){
        if(auth()->user()->user_type_id == 4 ){
            return $next($request);
        }
		}
        return redirect('login')->with('error','test');

    }
}
