@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Inicio</title>
</head>
@section('content')
<body >
        <div class="container-fluid">   
               <!-- Header -->
               <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Reportes</h1>
                </div>

                    <div class="row">
                    @if (Auth::user()->rol == 'Administrador')
                        <!-- Usuarios totales, visibles solo para el administrador -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Usuarios Registrados</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$usuarios}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                        <!-- Carreras profesionales totales -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Carreras profesionales totales
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$carreras}}</div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Carreras técnicas totales -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Carreras técnicas totales</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$tecnicas}}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Calendario -->
                    <div class="row">

                        <div class="col-md-12">
                            <div class="calendar calendar-first" id="calendar_first">
                                <div class="calendar_header">
                                    <button class="switch-month switch-left"> <i class="fa fa-chevron-left"></i></button>
                                    <h2></h2>
                                    <button class="switch-month switch-right"> <i class="fa fa-chevron-right"></i></button>
                                </div>
                                <div class="calendar_weekdays"></div>
                                <div class="calendar_content"></div>
                            </div>
                        </div>

                        
                    </div>

                    <!-- Approach -->
                    <div class="card shadow mb-4" style="margin-top: 3%">
                        <div class="card-header py-3" style="background-color: #333333;">
                            <h6 class="m-0 font-weight-bold" style="color: white">Acerca de</h6>
                        </div>
                        <div class="card-body">
                            <p>El sistema web Arquitectura Curricular tiene como finalidad entregar una plataforma para planificar los planes de estudio para las carreras impartidas
                                por la Universidad de Talca, ya sean planes para carreras nuevas o rediseños de una carrera ya existente. 
                            </p>
                            <p class="mb-0">Es necesario familiarizarse con los conceptos de "competencia", "dimensión", "aprendizaje" y "saber" antes de utilizar éste sistema.</p>
                        </div>
                    </div>

        </div>
  <script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/calendar.js"></script>
</body>
@endsection
</html>