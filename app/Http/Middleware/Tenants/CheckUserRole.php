<?php

namespace App\Http\Middleware\Tenants;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user() || Auth::user()->role_id !== 1) {
            return jsonResponse(message: __('messages.action_not_perform'), data: [], statusCode: 403);
        }

        return $next($request);
    }
}
