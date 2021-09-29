<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Draw;

class CheckLandAccess
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
        $draw = Draw::where('land_sub', $request->slug)->first();

        if ($draw)
        {
            if (!$draw->is_land)
                return redirect(url('/draws/'.$draw->slug));
        }
        else
                return redirect(url('/login'));
            
        return $next($request);
    }
}
