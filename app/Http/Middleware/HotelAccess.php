<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class HotelAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $hotelId = $request->route('hotel');

        if (Auth::user()->hasRole(['hotel manager', 'hotel clerk'])) {
            if (!Auth::user()->hotels->contains($hotelId)) {
                abort(403, 'Unauthorized access to this hotel.');
            }
        }

        return $next($request);
    }
}
