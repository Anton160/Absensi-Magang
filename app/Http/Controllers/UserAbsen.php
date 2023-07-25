<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;


class UserAbsen extends Controller
{

    public function absen()
    {

        return view('userAbsen.userAbsen', [
            'users' => User::where('id', auth()->user()->id)->get()
        ]);
    }

    public function store(Request $request)
    {
        if(is_null($request->latitude)){
            return redirect()->back()->with('location','Allow This Website to Access Your Location');
        }

        $validateData = $request->validate([
            'user_id' => 'required',
            'image' => 'required|image|file|max:2500',
            'latitude'=> 'required',
            'longitude'=> 'required'
        ]);



        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('present');
        }

        if ($request->absen === 'present') {

            $validateData['present'] = 1;
            $validateData['notAbsent'] = 0;
        } elseif ($request->absen === 'sick') {

            $validateData['sick'] = 1;
            $validateData['notAbsent'] = 0;
        } elseif ($request->absen === 'permission') {

            $validateData['permission'] = 1;
            $validateData['notAbsent'] = 0;
        } else {
            return redirect('/user-absen')->with('error', 'Error Occurred try Again');
        }

        $validateData['check_in'] = Carbon::now()->toTimeString();
        Attendance::create($validateData);

        return redirect('/dashboard')->with('absent-success', 'You Have Successfully Absent');
    }

    public function detail(Attendance $attendance)
    {
        return view('userAbsen.detailAbsen', [
            'attendance' => $attendance,
            'users' => User::where('id', $attendance->user_id)->get()
        ]);
    }

    public function check_out()
    {
        return view('userAbsen.checkOut', [
            'attendances' => Attendance::where('user_id', auth()->user()->id)->whereNull('check_out')->get()
        ]);
    }

    public function submitCheckout(Request $request)
    {


        $validateData['check_out'] = Carbon::now()->toTimeString();

        Attendance::where('id', $request->id)
            ->update($validateData);

        return redirect('/dashboard')->with('check-out', 'You have Successfully Check Out');
    }
}
