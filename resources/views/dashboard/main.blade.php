@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Welcome back, {{ auth()->user()->name }}</h1>
    </div>
    @if (session()->has('slot-absen'))
        <div class="alert alert-warning col-lg-8" role="alert">
            {{ session('slot-absen') }}
        </div>
    @endif
    @if (session()->has('national-holiday'))
        <div class="alert alert-warning col-lg-8" role="alert">
            {{ session('national-holiday') }}
        </div>
    @endif
    @if (session()->has('weekend'))
        <div class="alert alert-warning col-lg-8" role="alert">
            {{ session('weekend') }}
        </div>
    @endif
    @if (session()->has('absent-success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('absent-success') }}
        </div>
    @endif
    @if (session()->has('check-out'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('check-out') }}
        </div>
    @endif
    @if (session()->has('update'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('update') }}
        </div>
    @endif


    <form action="/dashboard">
        <div class="input-group mb-4">

            <input type="text" class="form-control" placeholder="Search.." name="search" value="{{ request('search') }}">
            <button class="btn btn-primary" type="submit">Search</button>
        </div>
    </form>
        <div class="row row-cols-1 row-cols-lg-4 g-4 pt-3">
            @foreach ($attendances as $attendance)
                <div class="col">
                    <div class="card h-100">
                        <div class="card-body">
                            <h5 class="card-title">Your attendance</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">Date: {{ $attendance->date }}</li>
                                <li class="list-group-item">Check in: {{ $attendance->check_in }}</li>
                                <li class="list-group-item">Check out: {{ $attendance->check_out }}</li>
                                <li class="list-group-item">Status: {{ $attendance->present ? 'present' : '' }}{{ $attendance->sick ? 'sick' : '' }}{{ $attendance->permission ? 'permission' : '' }}{{ $attendance->notAbsent ? 'Not Absent' : '' }}</li>
                            </ul>
                            <br>
                            <a href="user-absen/detail/{{ $attendance->id }}" class="btn btn-primary">Detail</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="d-flex  pt-5">
            {{ $attendances->onEachSide(2)->links() }}
        </div>
    @endsection
