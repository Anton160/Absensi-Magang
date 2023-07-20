<?php

namespace App\Jobs;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Helpers\Holidays;

class AutoAttendance implements ShouldQueue
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
        // Periksa hari ini apakah termasuk hari libur
        $today = Carbon::today()->toDateString();
        $isHoliday = in_array($today, Holidays::all());

        // Periksa apakah hari ini bukan hari libur, bukan Sabtu, dan bukan Minggu
        if (!$isHoliday && Carbon::today()->isWeekday()) {
            // Ambil semua pengguna
            $users = User::all();

            foreach ($users as $user) {
                // Periksa apakah pengguna sudah memiliki data absensi untuk hari ini
                $attendance = Attendance::where('user_id', $user->id)
                    ->whereDate('date', Carbon::today())
                    ->first();

                // Jika pengguna belum absen, tambahkan data absensi otomatis
                if (!$attendance) {
                    Attendance::create([
                        'user_id' => $user->id,
                        'present' => 0, // Ganti dengan nilai default yang diinginkan
                        'sick' => 0, // Ganti dengan nilai default yang diinginkan
                        'permission' => 0, // Ganti dengan nilai default yang diinginkan
                        'notAbsent' => 1, // Ganti dengan nilai default yang diinginkan
                        'check_in' => null,
                        'check_out' => null,
                        'date' => Carbon::today(),
                    ]);
                }
            }
        }
    }
}
