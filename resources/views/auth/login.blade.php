<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Universidad de Talca - Gestión de Planes de Estudio</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="js/dashboard.min.js"></script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">

</head>
<body style="background-color: #242424">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                                <div class="p-5">
                                @if(session('error'))
                                    <div class="alert alert-dismissable alert-danger">
                                        <strong>    
                                            {{session('error')}}
                                        </strong>
                                    </div>
                                @endif

                                @if (count($errors) > 0)
                                    <div class="alert alert-dismissable alert-danger">
                                        <u1>
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }} </li>
                                        @endforeach
                                        </u1>
                                    </div>
                                @endif
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4" style="font-size: 30px">¡Bienvenido!</h1>
                                    </div>
                                    <form method="post" action="/login">
                                        
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" name="email" placeholder="Ingrese su correo electrónico" style="width: 650px; margin: auto" required>
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user" placeholder="Contraseña" name="password" style="width: 650px; margin: auto" required> 
                                        </div>
                                        <div class="form-group" style="text-align: center;">
                                            <div class="custom-control custom-checkbox small">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                                Recordarme
                                            </label>
                                            </div>
                                        </div>
                                        <div style=" text-align: center;">
                                            <button type="submit" class="button-login" name="login" value="Login" style=" text-align: center; width: 200px">Conectarse</button>
                                        </div>
                                       
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Olvidé mi contraseña</a>
                                    </div>
                                    <div class="text-center">
                                        <img src="/images/utalca_icon.png" alt="">
                                    </div>
                                </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>
</html>

