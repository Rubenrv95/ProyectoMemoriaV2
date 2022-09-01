@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @foreach($name as $n)
    <title>Lista de Planes de Estudio de {{$n['nombre']}}</title>
    @endforeach
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>

@section('content')
<body>


    <div class="container-fluid">
        <a href="/carreras/"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
        @foreach($name as $n)
            <h1 class="mb-0 text-gray-800"> {{ $n['nombre'] }} </h1>
        @endforeach
        </div>
        @if (Auth::user()->rol != 'Dirección de docencia')
        <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_plan"  style="margin-bottom: 10px;">
            Agregar plan de estudio                    
        </button>
        @endif


        <table id="lista" class="table table-striped table-bordered" width="100%">
            <thead>
                <tr style="font-weight: bold; color: white">
                    <th style="display: none">ID </th>
                    <th style="display: none">Nombre</th>
                    <th>Plan⇵</th>
                    <th>Fecha de creación⇵</th>
                    <th>Fecha de actualización⇵</th>
                    <th></th>
                </tr>
            </thead>
            
            <tbody>
            
            
            @foreach($data as $item)
                <tr>
                    <td style="display: none"> {{ $item['id'] }}</td>
                    <td style="display: none">{{ $item['Nombre'] }}</td>
                    <td > <a href="/carreras/{{$id}}/{{ $item['id'] }}/competencias">{{ $item['Nombre'] }} </a></td>
                    <td > {{ $item['created_at'] }}</td>
                    <td >{{ $item['updated_at'] }}</td>
                    <td>
                        @if (Auth::user()->rol != 'Dirección de docencia')
                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_editar_plan" class="edit" style="padding-top: 2%"> </button>
                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_plan" class="delete">
                        <button type="button" id="copy" data-bs-toggle="modal" data-bs-target="#modal_copiar_plan" class="copy" style="margin-left: 2%">
                        @endif
                        <a href="/carreras/{{$id}}/{{ $item['id'] }}/descargar_reporte"><button type="button" id="download"  style="margin-left: 2%" > </button></a>
                    </td>
                </tr>    
            @endforeach
            </tbody>
            
        </table> 


        <!--Modal agregar plan de estudio -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1" class="modal fade" id="modal_crear_plan" aria-hidden="true"> 
                        <div class="modal-dialog modal-md">
                            <form action="/carreras/{{$id}}/crearPlan" method="POST" class="form-group">
                            @csrf
                            @method('POST')
                                <div class="modal-content" style="width: 600px">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Crear Plan de Estudio</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                                <label style="font-size: 20">Nombre del plan</label>
                                                <input class="form-control form-control-lg" name="nombre_plan" style="width:100%; color: black"  placeholder="Ingrese el nombre del plan" required/>        
                                            </div>

                                            <div class="form-group">
                                                <input name="nombre_carrera" type="hidden" value="{{ $id }}">              
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                                <button class="btn btn-success" type="submit">Guardar</button>
                                                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                                    </div> 
                                
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal modificar nombre plan de estudio -->
        <div class="container">
                <div class="row">
                    <div class ="col-md-12">
                        <div tabIndex="-1" class="modal fade" id="modal_editar_plan" aria-hidden="true"> 
                            <div class="modal-dialog modal-md">
                                <form action="/carreras/{{$id}}" method="POST" class="form-group" id = "editForm">
                                @csrf
                                @method('PUT')
                                    <div class="modal-content" style="width: 600px">

                                        <div class="modal-header">
                                            <h1 class="justify-content-center" style="margin: auto"> Modificar Plan de Estudio</h1>
                                        </div>
                                        <div class="modal-body">

                                                <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                                    <label style="font-size: 20">Nombre del plan</label>
                                                    <input class="form-control form-control-lg" name="nombre_plan" id="nombre_plan" style="width:100%; color: black"  placeholder="Ingrese el nombre del plan" required/>  
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit">Guardar</button>
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                                        </div> 
                                    
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
        </div>

        <!-- Modal eliminar plan   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_plan" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "POST" action = "/carreras/{{$id}}" class="form-group" id = "deleteForm">

                                {{ csrf_field() }}
                                {{ method_field('DELETE')}}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar Plan de Estudio</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="method"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar éste plan de estudio? Se eliminarán también todos los módulos y el perfil de egreso.</p>
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

        <!--Modal guardar como nuevo plan de estudio -->
        <div class="container">
                <div class="row">
                    <div class ="col-md-12">
                        <div tabIndex="-1" class="modal fade" id="modal_copiar_plan" aria-hidden="true"> 
                            <div class="modal-dialog modal-md">
                                <form action="" method="POST" class="form-group"  id = "copyForm">
                                @csrf
                                    <div class="modal-content" style="width: 600px">

                                        <div class="modal-header">
                                            <h1 class="justify-content-center" style="margin: auto"> Copiar Plan de Estudio</h1>
                                        </div>
                                        <div class="modal-body">

                                                <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                                    <label style="font-size: 20">Nombre del nuevo plan</label>
                                                    <input class="form-control form-control-lg" name="nombre_plan_nuevo" style="width:100%; color: black"  placeholder="Ingrese el nombre del nuevo plan" value="" required/>  
                                                </div>

                                        </div>
                                        <div class="modal-footer">
                                                    <button class="btn btn-success" type="submit">Guardar</button>
                                                    <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                                        </div> 
                                    
                                    </div>
                                </form>
                            </div>
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
            var table = $('#lista').DataTable( {
                "sDom": '<"top"f>        rt      <"bottom"ip>      <"clear">',
                "order": [[ 1, "asc" ]],

                language: {
                    "decimal": "",
                    "emptyTable": "No hay información",
                    "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                    "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
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

            //modificar
            table.on('click', '.edit', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();
                console.log(data);

                $('#nombre_plan').val(data[1]);

                $('#editForm').attr('action', '/carreras/{{$id}}/'+data[0]);
                $('#modal_modificar_dimension').modal('show');

            });

            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteForm').attr('action', '/carreras/{{$id}}/'+data[0]);
                $('#modal_eliminar_plan').modal('show');

            }  );

            //copiar
            table.on('click', '.copy', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();
                console.log(data);

                $('#copyForm').attr('action', '/carreras/{{$id}}/'+data[0] +'/copiar');
                $('#modal_copiar_plan').modal('show');

            });
            
        
            
        });

    </script>
</body>


</html>


@endsection
