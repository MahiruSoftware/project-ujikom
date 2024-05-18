<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Administrator;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user instanceof Administrator && $user->isAdmin()) {
            return $next($request);
        }

        return response()->json([
            'status' => 'forbidden',
            'message' => 'You are not the administrator'
        ], 403);
    }
}
