<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserAccount extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('admin');
        return view('userAccount.index', [
            'users' => User::latest()->filter(request(['search']))->simplePaginate(20)->withQueryString(),

        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('admin');
        return view('userAccount.create', [
            'users' => User::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('admin');
        $validateData = $request->validate([
            'name' => 'required|max:25',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|max:255',
            'image' => 'required|image|file|max:2500',
            'is_admin' => 'boolean',
            'is_itsupports' => 'boolean',
            'is_banned' => 'boolean'
        ]);


        if ($request->file('image')) {
            $validateData['image'] = $request->file('image')->store('post-image');
        }
        $validateData['password'] = Hash::make($validateData['password']);


        User::create($validateData);

        return redirect('/user-account')->with('success', 'Account has Been Successfully Added');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $this->authorize('admin');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $this->authorize('admin');

        return view('userAccount.edit', [
            'user' => $user,

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(User $user, Request $request)
    {
        $this->authorize('admin');
        $rule = ([
            'name' => 'required|max:25',
            'image' => 'image|file|max:2500',
            /*'is_admin'=>'boolean',
            'is_itsupports'=>'boolean',
            'is_banned'=>'boolean'*/
        ]);




        if ($request->email != $user->email) {
            $rule['email'] = 'required|email|unique:users,email';
        }
        $validateData = $request->validate($rule);


        if (isset($request->is_admin)) {
            $validateData['is_admin'] = 1;
        } else {
            $validateData['is_admin'] = 0;
        }

        if (isset($request->is_itsupports)) {
            $validateData['is_itsupports'] = 1;
        } else {
            $validateData['is_itsupports'] = 0;
        }

        if (isset($request->is_banned)) {
            $validateData['is_banned'] = 1;
        } else {
            $validateData['is_banned'] = 0;
        }


        if ($request->file('image')) {
            if ($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validateData['image'] = $request->file('image')->store('post-image');
        }
        if (isset($request->password)) {
            $validateData['password'] = Hash::make($request->password);
        }

        User::where('id', $user->id)
            ->update($validateData);

        return redirect('/user-account')->with('update', 'Account has Been Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $this->authorize('admin');

        if ($user->image) {
            Storage::delete($user->image);
        }
        $attendances = Attendance::where('user_id', $user->id)->get();
        foreach ($attendances as $attendance) {
            if ($attendance->image) {
                Storage::delete($attendance->image);
            }
        }
        Attendance::where('user_id', $user->id)->delete();

        User::destroy($user->id);
        return redirect('/user-account')->with('destroy', 'Account has Been Successfully Deleted');
    }
}
