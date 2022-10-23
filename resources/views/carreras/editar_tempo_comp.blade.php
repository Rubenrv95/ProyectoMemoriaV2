@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @foreach ($carrera as $c)
        @endforeach

        <title>Temporalización de competencias {{$c['nombre']}}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
@section('content')
<body >
        <div class="container-fluid">   
                
                <a href="/carreras/"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Competencias {{$c['nombre']}} </h1>
                </div>

                <hr class="solid" style="border-width: 1px; background-color: black">
                <a href="/carreras/{{$c['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/modulos"><button type="button" class="boton_gestionar">Módulos</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="/carreras/{{$c['id']}}/competencias"><button type="button" class="btn btn-secondary">Gestión de Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/dimensiones"><button type="button" class="btn btn-secondary">Gestión de Dimensiones</button></a> 
                <a href="/carreras/{{$c['id']}}/tempo_competencias"><button type="button" class="btn btn-secondary">Temporalización de Competencias</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

        </div>
        <div class="container-fluid" style="overflow-x:scroll; height: 92vh">   
            <a href="/carreras/{{$c['id']}}/tempo_competencias"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
            <h3 class="mb-0 text-gray-800">Editar temporalización</h3>

            @foreach ($tempo as $t)
            <form action="/carreras/{{$c['id']}}/tempo_competencias/{{$t['aprendizaje']}}" method="POST">
                @csrf
                @method('PUT')
                <table id="lista" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr style="font-weight: bold; color: white">
                            <th style="width: 20%; text-align: center">Competencia</th>
                            @for ($i = 1; $i <= 14; $i++)
                                <th style="text-align: center">Nivel {{$i}}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td  style="text-align: center">{{$t['Orden']}}. {{$t['Descripcion']}}</td>
                            @for ($i = 1; $i <= 14; $i++)
                            <td  style="text-align: center"> 
                                @if ($t[$i]== 1) 
                                    <input type="checkbox" value="1" id="nivel_{{$i}}" name="nivel_{{$i}}" style="width: 30px; height: 30px; text-align: center" checked>
                                @else
                                    <input type="checkbox" value="1" id="nivel_{{$i}}" name="nivel_{{$i}}" style="width: 30px; height: 30px; text-align: center">
                                @endif
                            </td>
                            @endfor                          
                        </tr>
                        
                    </tbody>
                </table>

                <div class="col text-center">
                    <button class="btn btn-success" id="save" type="submit" name="submit" id="submit"> Guardar</button>
                </div>
            </form>
            @endforeach

        </div>

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>    
        $(document).ready(function() {
            var table = $('#lista').DataTable({

                "sDom": '<"top"f>        rt      <"bottom"ip>      <"clear">',
                "order": [[ 1, "asc" ]],
                "bFilter": false,
                "bPaginate": false,

                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "",
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
