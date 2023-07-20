<?php

namespace App\Http\Middleware;

use App\Models\Attendance;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckInOncePerDay
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $checkInExists = Attendance::where('user_id', auth()->user()->id)
            ->whereDate('date', Carbon::today())
            ->exists();
        if ($checkInExists) {
            // Jika sudah melakukan check-in, redirect ke halaman lain atau tampilkan pesan kesalahan
            return redirect('dashboard')->with('slot-absen', 'You are Absent Today');
        }
        return $next($request);
    }
}
