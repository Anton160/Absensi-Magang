@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Absent</h1>
    </div>
    @if (session()->has('error'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('error') }}
        </div>
    @endif
    @if (session()->has('location'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('location') }}
        </div>
    @endif




    <div class="col-lg-8">
        <form action="/user-absen" method="post" class="mb-5" enctype="multipart/form-data">
            @csrf
            @foreach ($users as $user)
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" id="latitude" name="latitude">
                <input type="hidden" id="longitude" name="longitude">

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text"
                        class="form-control @error('name')
                is-invalid
            @enderror" id="name"
                        name="name" required value="{{ old('name', $user->name) }}" readonly value="">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="employee_id" class="form-label">Employee ID</label>
                    <input type="text"
                        class="form-control @error('employee_id')
                is-invalid
            @enderror"
                        id="employee_id" name="employee_id" required value="{{ old('employee_id', $user->employee_id) }}"
                        readonly>

                    @error('employee_id')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="" class="form-label">User Access</label>
                    <br>
                    <div class="btn-group" role="group" aria-label="Basic radio toggle button group">
                        <input type="radio" class="btn-check" name="absen" id="btnradio1" autocomplete="off" checked
                            value="present">
                        <label class="btn btn-outline-primary" for="btnradio1">Present</label>

                        <input type="radio" class="btn-check" name="absen" id="btnradio2" autocomplete="off"
                            value="sick">
                        <label class="btn btn-outline-primary" for="btnradio2">Sick</label>

                        <input type="radio" class="btn-check" name="absen" id="btnradio3" autocomplete="off"
                            value="permission">
                        <label class="btn btn-outline-primary" for="btnradio3">Permission</label>
                    </div>
                </div>



                <div class="mb-3">
                    <label for="image" class="form-label">Upload image</label>
                    <img class="img-preview img-fluid mb-3 col-sm-5">
                    <input type="file"
                        class="form-control @error('image')
                        is-invalid
                    @enderror"
                        id="image" name="image" onchange="previewImage()" accept="image/*" capture="camera">
                    @error('image')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <input class="btn btn-primary" type="submit" value="Submit">

            @endforeach

        </form>
    </div>

    <script>
        function previewImage() {
            // querySelector berguna untuk mengambil id atau class html
            const image = document.querySelector('#image')
            const imgPreview = document.querySelector('.img-preview');

            //atur cssnya
            imgPreview.style.display = "block";

            // baca filenya
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            //tampilkan gambarnya
            oFReader.onload = function(oFREvent) {
                imgPreview.src = oFREvent.target.result;
            }
        }

        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                let latitude = position.coords.latitude;
                let longitude = position.coords.longitude;

                // Mengisi nilai input hidden dengan latitude dan longitude
                document.getElementById('latitude').value = latitude;
                document.getElementById('longitude').value = longitude;
            });
        }




    </script>
@endsection
