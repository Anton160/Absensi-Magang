<?php

namespace App\Http\Middleware;

use App\Helpers\Holidays;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class HolidayRestrictionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $holidays = Holidays::all();
        $date = date('Y-m-d');
        $dayOfWeek = date('N');

        if (in_array($date, $holidays)) {
            return redirect('/dashboard')->with('national-holiday', 'Today is a holiday.');
        }
        if ($dayOfWeek == 6 || $dayOfWeek == 7) {
            return redirect('/dashboard')->with('weekend', 'Today is the weekend');
        }
        return $next($request);
    }
}
