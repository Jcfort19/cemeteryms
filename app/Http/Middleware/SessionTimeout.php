<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionTimeout
{
    public function handle(Request $request, Closure $next): Response
    {
        $timeout = (int) config('session.lifetime') * 60;
        $lastActivity = session('last_activity_at');

        if (auth()->check() && $lastActivity && now()->timestamp - $lastActivity > $timeout) {
            auth()->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')->withErrors(['email' => 'Your session expired. Please sign in again.']);
        }

        session(['last_activity_at' => now()->timestamp]);

        return $next($request);
    }
}
