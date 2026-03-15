<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
    {
        $admin = Auth::guard('admin')->user();
        if (! $admin) {
            return redirect()->route('admin.login.page');
        }
        // Access check
        if (! $admin->hasAccess($permission)) {
            abort(403, 'Aap ko is section ka access nahi hai.');
        }

        return $next($request);
    }
}
