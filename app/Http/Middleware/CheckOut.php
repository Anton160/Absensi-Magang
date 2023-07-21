<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckOut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $currentTime = Carbon::now();

        // Cek apakah waktu saat ini adalah pukul 15.00
        if ($currentTime->format('H:i') < '15:00') {
            // Jika waktu saat ini adalah pukul 15.00, maka kembalikan respon yang menolak akses
            return redirect('/dashboard')->with('check-out', "you can't go home now");
        }

        return $next($request);
    }
}
