@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @foreach ($carrera as $c)
        @endforeach

        <title>Visualización de saberes {{$c['nombre']}}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
@section('content')
<body >
        <div class="container-fluid">   
                
                <a href="<?=ENV('APP_URL')?>carreras"><img src="<?=ENV('APP_URL')?>images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Saberes {{$c['nombre']}} </h1>
                </div>

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/modulos"><button type="button" class="boton_gestionar">Módulos</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/archivos"><button type="button" class="boton_gestionar">Archivos</button></a> 


                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/saberes"><button type="button" class="btn btn-secondary">Gestión de Saberes</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/ver_saberes"><button type="button" class="btn btn-secondary">Visualización de Saberes</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

        </div>

        <div class="container-fluid" style="overflow-x:scroll; height: 92vh">   

            <h3 class="mb-0 text-gray-800">Visualización de Saberes</h3>
                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>

                            <tr style="font-weight: bold; color: white">
                                <th style="text-align: center; width: 20%">Competencia⇵</th>
                                <th style="text-align: center; width: 20%">Dimensión⇵</th>
                                <th style="text-align: center; width: 20%">Aprendizaje⇵</th>
                                <th style="text-align: center; width: 20%">Saber⇵</th>
                                <th style="text-align: center; width: 20%">Tipo de Saber⇵</th>
                                <th style="text-align: center; width: 20%">Fecha de Creación⇵</th>
                                <th style="text-align: center; width: 20%">Fecha de Actualización⇵</th>
                            </tr>

                        </thead>
                        
                        <tbody> 
                            @foreach ($saber as $s) 
                                <tr>
                                <td style="text-align: center">{{$s['OrdenComp']}}. {{$s['Descripcion']}}</td>
                                <td style="text-align: center">{{$s['OrdenDim']}}. {{$s['Descripcion_dimension']}}</td>
                                <td style="text-align: center">{{$s['Descripcion_aprendizaje']}}</td>
                                <td style="text-align: center">{{$s['Descripcion_saber']}}</td>
                                <td style="text-align: center">{{$s['Tipo']}}</td>
                                <td style="text-align: center">{{$s['created_at']}}</td>
                                <td style="text-align: center">{{$s['updated_at']}}</td>
                                </tr>
                            @endforeach

                        </tbody>
                </table> 


        </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>    
        $(document).ready(function() {
            var table = $('#lista').DataTable({

                "sDom": '<"top"f>        rt      <"bottom"ip>      <"clear">',
                "order": [[ 1, "asc" ]],

                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 a 0 de 0 Entradas",
                    "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                    "infoPostFix": "",
                    "thousands": ",",
                    "lengthMenu": "Mostrar _MENU_ Entradas",
                    "loadingRecords": "Cargando...",
                    "processing": "Procesando...",
                    "search": "Buscar:",
                    "zeroRecords": "Sin resultados encontrados",
                    "paginate": {
                        "first": "Primero",
                        "last": "Ultimo",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
            });
        });

    </script>
</body>
@endsection

</html>
