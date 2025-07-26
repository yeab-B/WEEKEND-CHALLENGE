<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleOrPermissionMiddleware
{
    public function handle(Request $request, Closure $next, $rolesOrPermissions)
    {
        $User = Auth::User();

        if (!$User) {
            abort(401, 'Unauthorized');
        }

        $items = is_array($rolesOrPermissions) ? $rolesOrPermissions : explode('|', $rolesOrPermissions);

        $hasAccess = false;

        foreach ($items as $item) {
            // Check role or permission
            if ($User->hasRole($item) || $User->can($item)) {
                $hasAccess = true;
                break;
            }
        }

        if (!$hasAccess) {
            abort(403, 'Forbidden: You do not have the required role or permission.');
        }

        return $next($request);
    }
}
