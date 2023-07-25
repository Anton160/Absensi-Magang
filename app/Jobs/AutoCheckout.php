<?php

namespace App\Jobs;

use App\Helpers\Holidays;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AutoCheckout implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $today = Carbon::today()->toDateString();
        $isHoliday = in_array($today, Holidays::all());

        if (!$isHoliday && Carbon::today()->isWeekday()) {
            $records=Attendance::whereNull('check_out')->get();
            foreach ($records as $record) {
                $record->update([
                    'check_out' => now(),
                ]);
            }
        }
    }
}
