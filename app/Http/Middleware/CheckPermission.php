<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Route;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission)
    {
        $pp = Auth::user()->getPerson->getRole->getPermission()
                          ->whereHas('getMenu', function($query) use($permission){
                    $query->where('route', $permission);
        })->first();

        if($pp == null)
        {
            if ($request->ajax() || $request->wantsJson()) 
            {
                return response('Unauthorized.', 403);
            }
            
            return redirect()->to(Route::getCurrentRoute()->getPrefix() . '/403');
        }

        return $next($request);
    }
}
