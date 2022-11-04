@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @foreach ($carrera as $c)
        @endforeach

        <title>Temporalización de aprendizajes {{$c['nombre']}}</title>
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
                        <h1 class="mb-0 text-gray-800">Aprendizajes {{$c['nombre']}} </h1>
                </div>

                <hr class="solid" style="border-width: 1px; background-color: black">
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/modulos"><button type="button" class="boton_gestionar">Módulos</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/archivos"><button type="button" class="boton_gestionar">Archivos</button></a> 


                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/aprendizajes"><button type="button" class="btn btn-secondary">Gestión de Aprendizajes</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/ver_aprendizajes"><button type="button" class="btn btn-secondary">Visualización de Aprendizajes</button></a> 
                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/tempo_aprendizajes"><button type="button" class="btn btn-secondary">Temporalización de Aprendizajes</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

        </div>
        <div class="container-fluid" style="overflow-x:scroll; height: 92vh">   
            <h3 class="mb-0 text-gray-800">Temporalización de Aprendizajes</h3>


            <form action="" method="post">
                <table id="lista" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr style="font-weight: bold; color: white">
                            <th style="width: 20%; text-align: center">Competencia Asociada⇵</th>
                            <th style="width: 20%; text-align: center">Nivel de Aprendizaje⇵</th>
                            <th style="width: 20%; text-align: center">Aprendizaje⇵</th>
                            <th style="width: 20%; text-align: center">Dimension⇵</th>
                            @for ($i = 1; $i <= 14; $i++)
                                <th style="text-align: center">Nivel {{$i}}</th>
                            @endfor
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tempo as $t)
                        <tr>
                            <td style="text-align: center">{{$t['Orden']}}. {{$t['Descripcion']}}</td>
                            <td style="text-align: center">{{$t['Nivel_aprend']}}</td>
                            <td style="text-align: center">{{$t['Descripcion_aprendizaje']}}</td>
                            <td style="text-align: center">{{$t['Descripcion_dimension']}}</td>

                            @for ($i = 1; $i <= 14; $i++)
                            <td style="text-align: center"> 
                                <!-- Se muestran las temporalizaciones, pero no se pueden editar-->
                                @if ($t[$i]== 1) 
                                <input type="checkbox" value="1" id="nivel[{{$i}}]" name="nivel[{{$i}}]" style="width: 30px; height: 30px; text-align: center;" checked onclick="return false;">
                                @else
                                <input type="checkbox" value="1" id="nivel[{{$i}}]" name="nivel[{{$i}}]" style="width: 30px; height: 30px; text-align: center" onclick="return false;">
                                @endif
                            </td>
                            @endfor
                            <td  style="text-align: center">
                            @if (Auth::user()->rol != 'Dirección de docencia')
                                <a href="<?=ENV('APP_URL')?>carreras/{{$c['id']}}/tempo_aprendizajes/{{$t['aprendizaje']}}"><button type="button" id="mod" class="edit"> </button> </a> 
                            @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    
            </form>
               

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
