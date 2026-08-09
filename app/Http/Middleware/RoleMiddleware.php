<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        if (empty($roles)) {
            abort(403);
        }

        $roleName = $user->role?->name;

        if ($user->role_id == 1 || ($roleName && in_array(strtolower($roleName), array_map('strtolower', $roles), true))) {
            return $next($request);
        }

        abort(403);
    }
}
