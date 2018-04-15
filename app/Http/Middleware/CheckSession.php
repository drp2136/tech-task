<?php
/**
 * Created by PhpStorm.
 * User: Dibyaranjan
 * Date: 4/14/2018
 * Time: 8:44 PM
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckSession
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
//        dd(Auth::check());
        if (Auth::check()) {
            return $next($request);
        } else {
            return redirect('/');
        }

    }
}
