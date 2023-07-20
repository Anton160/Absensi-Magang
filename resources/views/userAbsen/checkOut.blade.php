@extends('dashboard.layouts.main')

@section('container')
<div class="pt-3">
    @foreach ($attendances as $attendance)
    <div class="pt-4">
<div class="card">
    <div class="card-header">
      Check Out
    </div>
    <div class="card-body">
      <h5 class="card-title">Check Out</h5>
      <p class="card-text">before going home to end the absence on {{ $attendance->date }}</p>
      <form action="/check-out" method="post">
        @method('put')
        @csrf
        <input type="hidden" name="id" value="{{ $attendance->id }}">
        <input class="btn btn-primary" type="submit" value="Submit">
      </form>
    </div>
  </div>
    </div>
</div>

@endforeach

@endsection
