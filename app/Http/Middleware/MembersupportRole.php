<?php

namespace App\Http\Middleware;

use Closure;

class MembersupportRole
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
        if(auth()->user()->user_type_id == 3 ){
            return $next($request);
        }
        return redirect('login')->with('error','test');
    }
}
