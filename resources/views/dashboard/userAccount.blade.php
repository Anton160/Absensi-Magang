@extends('dashboard.layouts.main')

@section('container')

<div class="row pt-5">
    <div class="col-lg-4">
      <div class="card mb-4">
        <div class="card-body text-center">
          <img src="{{ asset('storage/' . $users->image) }}" alt="avatar"
            class="rounded-circle img-fluid" style="width: 150px;">
          <h5 class="my-3">{{ $users->name }}</h5>
          <div class="d-flex justify-content-center mb-2">
            <a href="/user-profile/edit/{{ $users->id }}" class="btn btn-primary">Chage Password</a>
          </div>
        </div>
      </div>

    </div>
    <div class="col-lg-8">
      <div class="card mb-4">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">Name</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0">{{ $users->name }}</p>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">Email</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0">{{ $users->email }}</p>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">User Id</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0">{{ $users->employee_id }}</p>
            </div>
          </div>
          <hr>
          <div class="row">
            <div class="col-sm-3">
              <p class="mb-0">This Account Created At</p>
            </div>
            <div class="col-sm-9">
              <p class="text-muted mb-0">{{ $users->created_at }}</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
