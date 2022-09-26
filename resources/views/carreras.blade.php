@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <title>Lista de Carreras</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
@section('content')
<body >
        <div class="container-fluid">   
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Lista de Carreras</h1>
                </div>

                @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_carrera" style="margin-bottom: 10px;">
                        Agregar carrera                    
                </button>
                @endif

                <table id="lista" class="table table-striped table-bordered" style="text-align: center" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID </th>
                                <th style="display: none">Nombre</th>
                                <th>Facultad⇵</th>
                                <th>Carrera⇵</th>
                                <th>Formación⇵</th>
                                <th>Planificación⇵</th>
                                <th style="width: 150px"></th>
                                </tr>
                        </thead>
                        
                        <tbody>
                        
                                @foreach($carrera as $item)
                                <tr>
                                <td style="display: none">{{$item['id']}}</td>
                                <td style="display: none">{{$item['nombre']}}</td>
                                <td>{{$item['facultad']}}</td>
                                <td><a href="/carreras/{{$item['id']}}/competencias">{{$item['nombre']}} </a> </td>
                                <td>{{$item['formacion']}}</td>
                                <td>{{$item['tipo']}}</td>
                                <td style="width: 10%">
                                        @if (Auth::user()->rol != 'Dirección de docencia')
                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_carrera" class="edit"> </button>
                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_carrera" class="delete"> </button>
                                        <button type="button" id="copy" data-bs-toggle="modal" data-bs-target="#modal_copiar_carrera" class="copy" style="margin-left: 2%">
                                        @endif
                                        <a href="/carreras/{{ $item['id'] }}/descargar_reporte"><button type="button" id="download"  style="margin-left: 2%" > </button></a>
                                        
                                </td>
                                
                                </tr>
                                @endforeach
                        
                        </tbody>
                </table> 

        </div>

        <!-- Modal crear carrera   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_carrera" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="crearCarrera" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar carrera</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Facultad</label>
                                                <select class="form-select form-select-lg" name="facultad" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione una facultad</option>
                                                    <option value="Linares">Linares</option>
                                                    <option value="Los Niches">Los Niches</option>       
                                                    <option value="Santiago">Santiago</option>      
                                                    <option value="Talca">Talca</option>                                                 
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                                <label style="font-size: 20">Nombre de la carrera</label>
                                                <input class="form-control form-control-lg" name="nombre_carrera" style="width:100%; color: black"  placeholder="Ingrese el nombre de la carrera" maxlength="191" required/>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Formación</label>
                                                <select class="form-select form-select-lg" name="formacion" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione un tipo de formación</option>
                                                    <option value="Profesional">Profesional</option>
                                                    <option value="Técnica">Técnica</option>                                                   
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Planificación</label>
                                                <select class="form-select form-select-lg" name="tipo" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione la planificación de la carrera</option>
                                                    <option value="Nueva">Nueva</option>
                                                    <option value="Rediseño">Rediseño</option>                                                   
                                                </select>
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


        <!-- Modal modificar carrera   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_carrera" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "post" action = "/carreras" class="form-group" id = "editForm">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar carrera</h1>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group" style="margin: auto">
                                            <label style="font-size: 20">Facultad</label>
                                            <select class="form-select form-select-lg" name="facultad" id = "facultad" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione una facultad</option>
                                                    <option value="Linares">Linares</option>
                                                    <option value="Los Niches">Los Niches</option>       
                                                    <option value="Santiago">Santiago</option>      
                                                    <option value="Talca">Talca</option>      
                                            </select>
                                        </div>
                                        
                                        <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                            <label style="font-size: 20">Nombre de la carrera</label>
                                            <input class="form-control form-control-lg" name="nombre_carrera" id ="nombre_carrera" style="width:100%; color: black" value="" placeholder="Ingrese el nombre de la carrera" maxlength="191" required/>
                                        </div>

                                        <div class="form-group" style="margin: auto">
                                            <label style="font-size: 20">Formación</label>
                                            <select class="form-select form-select-lg" name="formacion" id="formacion" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                <option selected disabled="true" value="">Seleccione un tipo de formación</option>
                                                <option value="Profesional">Profesional</option>
                                                <option value="Técnica">Técnica</option>                                                   
                                            </select>
                                        </div>

                                        <div class="form-group" style="margin: auto">
                                            <label style="font-size: 20">Planificación</label>
                                            <select class="form-select form-select-lg" name="tipo" id="tipo" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                <option selected disabled="true" value="">Seleccione la planificación de la carrera</option>
                                                <option value="Nueva">Nueva</option>
                                                <option value="Rediseño">Rediseño</option>                                                     
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-success">Guardar</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button"> Cancelar</button>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Modal eliminar carrera   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_carrera" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "post" action = "/carreras" class="form-group" id = "deleteForm">

                                {{ csrf_field() }}
                                {{ method_field('DELETE')}}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar Carrera</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar ésta carrera? Se eliminarán también todos los planes de estudio vinculados.</p>
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

        <!--Modal copiar carrera -->
        <div class="container">
                <div class="row">
                    <div class ="col-md-12">
                        <div tabIndex="-1" class="modal fade" id="modal_copiar_carrera" aria-hidden="true"> 
                            <div class="modal-dialog modal-md">
                                <form action="" method="POST" class="form-group"  id = "copyForm">
                                @csrf
                                    <div class="modal-content" style="width: 600px">

                                        <div class="modal-header">
                                            <h1 class="justify-content-center" style="margin: auto"> Copiar Carrera</h1>
                                        </div>
                                        <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                                <label style="font-size: 20">Nombre de la carrera</label>
                                                <input class="form-control form-control-lg" name="nombre_carrera_nueva" id ="nombre_carrera_nueva" style="width:100%; color: black" value="" placeholder="Ingrese el nombre de la carrera" maxlength="191" required/>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Facultad</label>
                                                <select class="form-select form-select-lg" name="facultad_nueva" id = "facultad_nueva" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                        <option selected disabled="true" value="">Seleccione una facultad</option>
                                                        <option value="Linares">Linares</option>
                                                        <option value="Los Niches">Los Niches</option>       
                                                        <option value="Santiago">Santiago</option>      
                                                        <option value="Talca">Talca</option>      
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Formación</label>
                                                <select class="form-select form-select-lg" name="formacion_nueva" id="formacion_nueva" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione un tipo de formación</option>
                                                    <option value="Profesional">Profesional</option>
                                                    <option value="Técnica">Técnica</option>                                                   
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Planificación</label>
                                                <select class="form-select form-select-lg" name="tipo_nuevo" id="tipo_nuevo" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione la planificación de la carrera</option>
                                                    <option value="Nueva">Nueva</option>
                                                    <option value="Rediseño">Rediseño</option>                                                      
                                                </select>
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

                $('#nombre_carrera').val(data[1]);
                $('#facultad').val(data[2]);
                $('#formacion').val(data[4]);
                $('#tipo').val(data[5]);

                $('#editForm').attr('action', '/carreras/'+data[0]);
                $('#modal_modificar_carrera').modal('show');

            });


            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteForm').attr('action', '/carreras/'+data[0]);
                $('#modal_eliminar_carrera').modal('show');

            }  );

            //copiar
            table.on('click', '.copy', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();
                console.log(data);

                $('#copyForm').attr('action', '/carreras/'+data[0] +'/copiar');
                $('#modal_copiar_carrera').modal('show');

            });
            
        });

    </script>
</body>
@endsection

</html>
