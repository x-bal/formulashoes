<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Login - {{ config('app.name') }}</title>
    <!-- Simple bar CSS -->
    <link rel="stylesheet" href="css/simplebar.css">
    <!-- Fonts CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <!-- Icons CSS -->
    <link rel="stylesheet" href="css/feather.css">
    <!-- Date Range Picker CSS -->
    <link rel="stylesheet" href="css/daterangepicker.css">
    <!-- App CSS -->
    <link rel="stylesheet" href="css/app-light.css" id="lightTheme">
    <link rel="stylesheet" href="css/app-dark.css" id="darkTheme" disabled>
</head>

<body class="light ">
    <div class="wrapper vh-100">
        <div class="row pt-5 h-100 w-100 d-flex">
            <div class="col-lg-7" style="margin-top: 50px;">
                <div class="container ml-5">
                    <h1 style="font-size: 64px;">Formula Shoes</h1>
                    <h5 style="margin-top: -15px;">The essential of clean shoes</h5>

                    <h4 style="margin-top: 15rem;">Belum punya akun? Daftar sekarang!</h4>
                    <a href="/register" class="btn btn-lg btn-primary" style="width: 10rem; margin-top: 20px;">Daftar</a>
                </div>
            </div> <!-- ./col -->
            <div class="col-lg-5">
                <div class=" mx-auto my-5 py-5 border shadow rounded" style="width: 25rem;">
                    <form class="mx-auto text-center p-4" action="{{ route('login') }}" method="POST">
                        @csrf
                        <a class="navbar-brand mx-auto mt-2 flex-fill text-center" href="/">
                            <img src="{{ asset('/') }}assets/images/formulashoe.png" alt="" class="navbar-brand-img mb-3" width="150">
                        </a>
                        <h1 class="h6 mb-3">Sign in</h1>
                        <div class="form-group">
                            <label for="username" class="">Username</label>
                            <input type="text" id="username" class="form-control form-control-lg" placeholder="Username" required="" autofocus="" name="username">

                            @error('username')
                            <small class="text-danger mt-2">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="">Password</label>
                            <input type="password" id="inputPassword" class="form-control form-control-lg" placeholder="Password" required="" name="password">
                        </div>

                        <button class="btn btn-lg btn-primary btn-block" type="submit">Login</button>
                    </form>
                </div> <!-- .card -->
            </div> <!-- ./col -->
        </div> <!-- .row -->
    </div>
    <script src="js/jquery.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/moment.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/simplebar.min.js"></script>
    <script src="js/daterangepicker.js"></script>
    <script src="js/jquery.stickOnScroll.js"></script>
    <script src="js/tinycolor-min.js"></script>
    <script src="js/config.js"></script>
    <script src="js/apps.js"></script>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-56159088-1"></script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'UA-56159088-1');
    </script>
</body>

</html>
</body>

</html>