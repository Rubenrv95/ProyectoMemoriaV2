<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Planificación de Planes de Estudio</title>
    

     <!-- CSRF Token -->
     <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="js/dashboard.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('/css/custom.css') }}" rel="stylesheet">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{ asset('/css/dashboard.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css'> 

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
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{session('error')}}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="width: 3%; height: 5%; margin-top: 0.5%"></button>
                                        </div>                      
                                    @endif

                                    @if (count($errors) > 0)
                                        @foreach($errors->all() as $error)
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ $error }}</strong>
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" style="width: 3%; height: 5%; margin-top: 0.5%"></button>
                                        </div>      
                                        @endforeach
                                    @endif
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4" style="font-size: 30px">¡Bienvenido!</h1>
                                        </div>
                                        <form method="post" action="<?=ENV('APP_URL')?>login">
                                            
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <input type="email" class="form-control form-control-user" name="email" placeholder="Ingrese su correo electrónico" style="width: 650px; margin: auto" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" placeholder="Contraseña" name="password" style="width: 650px; margin: auto" required> 
                                            </div>
                                            
                                            <div style=" text-align: center;">
                                                <button type="submit" class="button-login" name="login" value="Login" style=" text-align: center; width: 200px">Conectarse</button>
                                            </div>
                                        
                                            <hr>
                                        </form>
                                        <div class="text-center">
                                            <img src="<?=ENV('APP_URL')?>images/utalca_icon.png" alt="">
                                        </div>
                                </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</body>
</html>

