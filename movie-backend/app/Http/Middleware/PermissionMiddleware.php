<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionMiddleware
{
    public function handle(Request $request, Closure $next, $permission)
    {
        $user = Auth::user();

        if (!$user) {
            abort(401, 'Unauthorized');
        }

        // Check if user has the permission using Gate
        if (!\Illuminate\Support\Facades\Gate::allows($permission)) {
            abort(403, 'Forbidden: You do not have the required permission.');
        }

        return $next($request);
    }
}
