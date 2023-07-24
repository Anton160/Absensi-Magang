@extends('dashboard.layouts.main')

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2"></h1>
    </div>

    <div class="col-lg-8">
        <form action="" method="post" class="mb-5" enctype="multipart/form-data">
            @csrf


            <input type="hidden" name="user_id" value="{{ $attendance->user->id }}">

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control @error('name')
                is-invalid
            @enderror"
                    id="name" name="name" required value="{{ old('name', $attendance->user->name) }}" readonly>

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
                    id="employee_id" name="employee_id" required
                    value="{{ old('employee_id', $attendance->user->employee_id) }}" readonly>

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
                    <input type="radio" class="btn-check" name="absen" id="btnradio1" autocomplete="off" value="present"
                        disabled {{ $attendance->present ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="btnradio1">Present</label>

                    <input type="radio" class="btn-check" name="absen" id="btnradio2" autocomplete="off" value="sick"
                        disabled {{ $attendance->sick ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="btnradio2">Sick</label>

                    <input type="radio" class="btn-check" name="absen" id="btnradio3" autocomplete="off"
                        value="permission" disabled {{ $attendance->permission ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="btnradio3">Permission</label>
                    <input type="radio" class="btn-check" name="absen" id="btnradio4" autocomplete="off"
                        value="Not Absent" disabled {{ $attendance->Absent ? 'checked' : '' }}>
                    <label class="btn btn-outline-primary" for="btnradio4">Not Absent</label>
                </div>
            </div>



            <div class="mb-3">
                <label for="image" class="form-label">Upload image</label>
                <input type="hidden" name="oldImage" value="{{ $attendance->image }}">
                @if ($attendance->image)
                    <img src="{{ asset('storage/' . $attendance->image) }}"
                        class="img-preview img-fluid mb-3 col-sm-5 d-block">
                @else
                    <img class="img-preview img-fluid mb-3 col-sm-5">
                @endif
                <img class="img-preview img-fluid mb-3 col-sm-5">
                <input type="file"
                    class="form-control @error('image')
                            is-invalid
                        @enderror"
                    id="image" name="image" onchange="previewImage()" disabled>
                @error('image')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="check_in" class="form-label">Check_in</label>
                <input type="text" class="form-control" id="check_in" value="{{ $attendance->check_in }}" readonly>
            </div>

            <div class="mb-3">
                <label for="check_out" class="form-label">Check_out</label>
                <input type="text" class="form-control" id="check_out" value="{{ $attendance->check_out }}"
                    readonly>
            </div>

            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" value="{{ $attendance->latitude }},{{ $attendance->longitude}}"
                readonly>
            </div>





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
