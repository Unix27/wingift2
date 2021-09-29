<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Draw;

class CheckDrawAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $draw = Draw::where('slug', $request->slug)->firstOrFail();

        if(!$draw->is_free && !\Auth::user() )
            return redirect(url('/'));
            
        if(!$draw->is_free && !\Auth::user()->isSubscribed)
            return redirect(url('/account/subscription'));
            
        return $next($request);
    }
}
