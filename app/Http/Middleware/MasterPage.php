<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use JavaScript;
use App\Facades\MyFacades\QuickTaskFacade;

class MasterPage
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::check()) {
            QuickTaskFacade::PrepareMasterPageNotification();
        }
        return $next($request);
    }
}
