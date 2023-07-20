<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.84.0">
    <title>UserLogin</title>





    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="/bootstrap-5.3.0-alpha1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-5.3.0-alpha1-dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="/css/signin.css">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>



</head>

<body class="text-center">



    <main class="form-signin">

        <form action="/userLogin" method="post">
            @csrf
            <img class="mb-4" src="assets/mixue.jpg" alt="" width="72" height="57">
            <h1 class="h3 mb-3 fw-normal">Please sign in</h1>

            @if (session()->has('banned'))
                <div class="alert alert-danger alert-dismissble fade show" role="alert">
                    {{ session('banned') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissble fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissble fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="form-floating">
                <input type="text" class="form-control @error('name')is-invalid
      @enderror" id="name"
                    placeholder="name@example.com" name="name">
                <label for="name">User Name</label>

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>


            <div class="form-floating">
                <input type="text" class="form-control @error('employee_id')is-invalid
                @enderror"
                    id="employee_id" placeholder="name@example.com" name="employee_id">
                <label for="employee-id">Employee id</label>

                @error('employee_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>




            <div class="form-floating">
                <input type="password" class="form-control @error('password')is-invalid
                @enderror"
                    id="floatingPassword" placeholder="Password" name="password">
                <label for="floatingPassword">Password</label>
            </div>

            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" value="remember-me"> Remember me
                </label>
            </div>
            <button class="w-100 btn btn-lg btn-primary" type="submit">Sign in</button>
            <p class="mt-5 mb-3 text-muted">&copy; 2017–2021</p>
        </form>
    </main>



</body>

</html>
