@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @foreach ($carrera as $c)
        @endforeach

        <title>Archivos {{$c['nombre']}}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
@section('content')
<body >
        <div class="container-fluid">   
                
                <a href="/carreras"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Archivos {{$c['nombre']}} </h1>
                </div>

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="/carreras/{{$c['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/modulos"><button type="button" class="boton_gestionar">Módulos</button></a> 
                <a href="/carreras/{{$c['id']}}/archivos"><button type="button" class="boton_gestionar">Archivos</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

        </div>

        <div class="container-fluid" style="overflow-x:scroll; height: 92vh">   

            <h3 class="mb-0 text-gray-800">Visualización de Archivos</h3>

            @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_subir_archivo" style="margin-bottom: 1%; margin-top: 1%">
                        Subir archivo                
                </button>
            @endif

                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>

                            <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID </th>
                                <th style="text-align: center; width: 20%">Nombre⇵</th>
                                <th style="text-align: center; width: 20%">Fecha de Subida⇵</th>
                                <th style="text-align: center; width: 20%"></th>
                            </tr>

                        </thead>
                        
                        <tbody> 
                                @foreach ($archivo as $a)
                                <tr>
                                    <td style="text-align: center; display: none">{{$a['id']}}</td>
                                    <td style="text-align: center">{{$a['nombre']}}</td>
                                    <td style="text-align: center">{{$a['created_at']}}</td>
                                    <td style="text-align: center">
                                        <a href="/carreras/{{$c['id']}}/archivos/{{$a['file']}}"><button type="button" id="download" > </button></a>
                                        @if (Auth::user()->rol != 'Dirección de docencia')
                                            <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_archivo" class="delete"> </button>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                </table> 


        </div>

        <!-- Modal subir archivo-->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_subir_archivo" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/archivos/subir" method="POST" enctype="multipart/form-data">                            
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar archivo</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                                <label style="font-size: 20; font-weight: bold">Nombre del archivo</label>
                                                <input class="form-control form-control-lg" type="text" name="nombre" style="width:100%; color: black"  placeholder="Nombre del archivo" maxlength="191" required/>
   
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 2%;">
                                                <input type="file" name="file" style="margin-top: 1%; margin-bottom: 1%" required>
                                            </div>


                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit"> Guardar</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button"> Cancelar</button>
                                    </div> 
                                
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--modal eliminar archivo -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_archivo" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "POST" action = "/carreras/{{$c['id']}}/archivos/" class="form-group" id = "deleteForm">

                                @csrf
                                @method('DELETE')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar archivo</h1>
                                    </div>
                                    <div class="modal-body" style="text-align: center">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar éste archivo?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
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

            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();


                $('#deleteForm').attr('action', '/carreras/{{$c['id']}}/archivos/'+data[0]);
                $('#modal_eliminar_archivo').modal('show');

            }  );

        });

    </script>
</body>
@endsection

</html>
