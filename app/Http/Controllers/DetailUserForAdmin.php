<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Torann\GeoIP\Facades\GeoIP;

class DetailUserForAdmin extends Controller
{
    public function detail(User $user)
    {
        $this->authorize('admin');
        if(auth()->user()->id === $user->id){
            return redirect()->back()->with('ilegal', 'You are Not Allowed to Edit Your Account');
        }
        return view('adminAbsen.userAbsen', [
            'user' => $user,
            'attendances' => Attendance::latest()->where('user_id', $user->id)->filter(request(['search']))->simplePaginate(25)->withQueryString(),
        ]);
    }

    public function detailAbsen(Attendance $attendance)
    {
        $this->authorize('admin');
        return view('adminAbsen.detailAbsen', [
            'attendance' => $attendance,
            'users' => User::where('id', $attendance->user_id)->get(),
        ]);
    }

    public function update(Attendance $attendance, Request $request)
    {
        $this->authorize('admin');


        if ($request->absen === 'present') {

            $validateData['present'] = 1;
            $validateData['sick'] = 0;
            $validateData['permission'] = 0;
            $validateData['notAbsent'] = 0;
        } elseif ($request->absen === 'sick') {

            $validateData['sick'] = 1;
            $validateData['permission'] = 0;
            $validateData['present'] = 0;
            $validateData['notAbsent'] = 0;
        } elseif ($request->absen === 'permission') {

            $validateData['permission'] = 1;
            $validateData['present'] = 0;
            $validateData['sick'] = 0;
            $validateData['notAbsent'] = 0;
        } elseif ($request->absen === 'Not Absent') {
            $validateData['notAbsent'] = 1;
            $validateData['permission'] = 0;
            $validateData['present'] = 0;
            $validateData['sick'] = 0;
        } else {
            return redirect()->back()->with('error', 'there is an error');
        }

        Attendance::where('id', $attendance->id)
            ->update($validateData);
        return redirect()->back();
    }
}
