<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard</title>
    <link rel="stylesheet" href="/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>


    <!-- Custom styles for this template -->
    <link href="/css/dashboard.css" rel="stylesheet">


    {{-- Trix editor --}}
    {{-- kita gunakan trix sebagai tempat untuk nulis pada form --}}


</head>

<body>

    @include('dashboard.layouts.header')

    <div class="container-fluid">
        <div class="row">
            @include('dashboard.layouts.sidebar')

            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                @yield('container')
            </main>
        </div>
    </div>


</body>

</html>
