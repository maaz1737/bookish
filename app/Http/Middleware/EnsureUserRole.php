<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Role-Based Access Control (Section 15).
 * Usage in routes: ->middleware('role:admin,super_admin')
 */
class EnsureUserRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user || $user->is_blocked) {
            abort(403, 'Account is blocked or unauthenticated.');
        }

        if (! in_array($user->role, $roles, true)) {
            abort(403, 'Insufficient role permissions.');
        }

        return $next($request);
    }
}
