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
            <h3 class="mb-0 text-gray-800">Temporalización de Competencias</h3>

            <table id="lista" class="table table-striped table-bordered" width="100%">
                <thead>
                    <tr style="font-weight: bold; color: white">
                        <th style="width: 20%; text-align: center">Competencia⇵</th>
                        @for ($i = 1; $i <= 14; $i++)
                            <th style="text-align: center">Nivel {{$i}}</th>
                        @endfor
                        <th  style="text-align: center"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tempo as $t)
                    <tr>
                        <td  style="text-align: center">{{$t['Orden']}}. {{$t['Descripcion']}}</td>
                        @for ($i = 1; $i <= 14; $i++)
                        <td  style="text-align: center"> 
                            @if ($t[$i]== 1) 
                                <input type="checkbox" class="form-check-input" value="1" id="nivel[{{$i}}]" name="nivel[{{$i}}]" style="width: 30px; height: 30px; text-align: center;" checked onclick="return false;">
                            @else
                                <input type="checkbox" class="form-check-input" value="1" id="nivel[{{$i}}]" name="nivel[{{$i}}]" style="width: 30px; height: 30px; text-align: center" onclick="return false;">
                            @endif
                        </td>
                        @endfor
                        <td  style="text-align: center">
                        <a href="/carreras/{{$c['id']}}/tempo_competencias/{{$t['competencia']}}"><button type="button" id="mod" class="edit"> </button> </a> </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

         <!-- Modal modificar temporalización  -->
         <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_modificar_tempo" aria-hidden="true">
                        <div class="modal-dialog modal-lg" style="width: 200%">
                            <form action="/carreras/{{$c['id']}}/carga_academica" method="POST" class="form-group" name="tempo" id="tempo">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto; text-align: center">Temporalización de Competencia</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="clases" >
                                                <label style="font-size: 14; color: black">Nivel 1</label> 
                                                <input class="form-check-input" type="checkbox" value="1"name="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 5%">Nivel 2</label>         
                                                <input class="form-check-input" type="checkbox" value="1"name="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 5%">Nivel 3</label>          
                                                <input class="form-check-input" type="checkbox" value="1"name="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 5%">Nivel 4</label>          
                                                <input class="form-check-input" type="checkbox" value="1"name="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 5%">Nivel 5</label>          
                                                <input class="form-check-input" type="checkbox" value="1"name="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 5%">Nivel 6</label>          
                                                <input class="form-check-input" type="checkbox" value="1"name="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 5%">Nivel 7</label>          
                                                <input class="form-check-input" type="checkbox" value="1"name="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black;">Nivel 8</label>                                          
                                            </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="submit" id="submit"> Guardar</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button"> Cancelar</button>
                                    </div> 
                                
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
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
