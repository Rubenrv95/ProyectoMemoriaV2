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
                                <th style="width: 25%;text-align: center">Facultad⇵</th>
                                <th style="width: 35%;text-align: center">Carrera⇵</th>
                                <th style="width: 15%;text-align: center">Formación⇵</th>
                                <th style="width: 10%;text-align: center">Tipo⇵</th>
                                <th style="width: 15%; text-align: center"></th>
                                </tr>
                        </thead>
                        
                        <tbody>
                        
                                @foreach($carrera as $item)
                                <tr>
                                <td style="display: none">{{$item['id']}}</td>
                                <td style="display: none">{{$item['nombre']}}</td>
                                <td style="text-align: center">{{$item['facultad']}}</td>
                                <td style="text-align: center; word-wrap: break-word; max-width:0;"><a href="<?=ENV('APP_URL')?>carreras/{{$item['id']}}/competencias">{{$item['nombre']}} </a> </td>
                                <td style="text-align: center">{{$item['formacion']}}</td>
                                <td style="text-align: center">{{$item['tipo']}}</td>
                                <td style="text-align: center">
                                        @if (Auth::user()->rol != 'Dirección de docencia')
                                        <button title="Editar" type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_carrera" class="edit"> </button>
                                        <button title="Eliminar" type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_carrera" class="delete"> </button>
                                        @endif
                                        <a href="<?=ENV('APP_URL')?>carreras/{{ $item['id'] }}/descargar_reporte"><button title="Generar reporte PDF" type="button" id="pdf"  style="margin-left: 2%" > </button></a>
                                        <a href="<?=ENV('APP_URL')?>carreras/{{ $item['id'] }}/descargar_tabla"><button title="Generar tabla Excel" type="button" id="excel"  style="margin-left: 2%" > </button></a>
                                        
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
                                                <label style="font-size: 20; font-weight: bold">Facultad</label>
                                                <select class="form-select form-select-lg" name="facultad" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione una facultad</option>
                                                    <option value="Facultad de Arquitectura, Música y Diseño">Facultad de Arquitectura, Música y Diseño</option>   
                                                    <option value="Facultad de Ciencias Agrarias">Facultad de Ciencias Agrarias</option>   
                                                    <option value="Facultad de Ciencias de la Educación">Facultad de Ciencias de la Educación</option>  
                                                    <option value="Facultad de Ciencias de la Salud">Facultad de Ciencias de la Salud</option>                                                        
                                                    <option value="Facultad de Ciencias Jurídicas y Sociales">Facultad de Ciencias Jurídicas y Sociales</option> 
                                                    <option value="Facultad de Economía y Negocios">Facultad de Economía y Negocios</option>        
                                                    <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>      
                                                    <option value="Facultad de Odontología">Facultad de Odontología</option>   
                                                    <option value="Facultad de Psicología">Facultad de Psicología</option>                                               
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                                <label style="font-size: 20; font-weight: bold">Nombre de la carrera</label>
                                                <input class="form-control form-control-lg" name="nombre_carrera" style="width:100%; color: black"  placeholder="Ingrese el nombre de la carrera" maxlength="191" required/>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20; font-weight: bold">Formación</label>
                                                <select class="form-select form-select-lg" name="formacion" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione un tipo de formación</option>
                                                    <option value="Profesional">Profesional</option>
                                                    <option value="Técnica">Técnica</option>                                                   
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20; font-weight: bold">Planificación</label>
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

                            <form method = "post" action = "<?=ENV('APP_URL')?>carreras" class="form-group" id = "editForm">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Editar carrera</h1>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group" style="margin: auto">
                                            <label style="font-size: 20; font-weight: bold">Facultad</label>
                                            <select class="form-select form-select-lg" name="facultad" id = "facultad" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione una facultad</option>
                                                    <option value="Facultad de Arquitectura, Música y Diseño">Facultad de Arquitectura, Música y Diseño</option>   
                                                    <option value="Facultad de Ciencias Agrarias">Facultad de Ciencias Agrarias</option>   
                                                    <option value="Facultad de Ciencias de la Educación">Facultad de Ciencias de la Educación</option>  
                                                    <option value="Facultad de Ciencias de la Salud">Facultad de Ciencias de la Salud</option>                                                        
                                                    <option value="Facultad de Ciencias Jurídicas y Sociales">Facultad de Ciencias Jurídicas y Sociales</option> 
                                                    <option value="Facultad de Economía y Negocios">Facultad de Economía y Negocios</option>        
                                                    <option value="Facultad de Ingeniería">Facultad de Ingeniería</option>      
                                                    <option value="Facultad de Odontología">Facultad de Odontología</option>   
                                                    <option value="Facultad de Psicología">Facultad de Psicología</option>       
                                            </select>
                                        </div>
                                        
                                        <div class="form-group" style="margin: auto; margin-bottom: 2%">
                                            <label style="font-size: 20; font-weight: bold">Nombre de la carrera</label>
                                            <input class="form-control form-control-lg" name="nombre_carrera" id ="nombre_carrera" style="width:100%; color: black" value="" placeholder="Ingrese el nombre de la carrera" maxlength="191" required/>
                                        </div>

                                        <div class="form-group" style="margin: auto">
                                            <label style="font-size: 20; font-weight: bold">Formación</label>
                                            <select class="form-select form-select-lg" name="formacion" id="formacion" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                <option selected disabled="true" value="">Seleccione un tipo de formación</option>
                                                <option value="Profesional">Profesional</option>
                                                <option value="Técnica">Técnica</option>                                                   
                                            </select>
                                        </div>

                                        <div class="form-group" style="margin: auto">
                                            <label style="font-size: 20; font-weight: bold">Planificación</label>
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
                            <form method = "post" action = "<?=ENV('APP_URL')?>carreras" class="form-group" id = "deleteForm">

                                {{ csrf_field() }}
                                {{ method_field('DELETE')}}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar Carrera</h1>
                                    </div>
                                    <div class="modal-body" style="text-align: center">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">
                                        ¿Está seguro de que desea eliminar ésta carrera? Se eliminarán también todos los elementos vinculados a ésta.
                                    </p>
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
                "order": [[ 2, "asc" ]],

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

            

            //modificar
            table.on('click', '.edit', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();

                $('#nombre_carrera').val(data[1]);
                $('#facultad').val(data[2]);
                $('#formacion').val(data[4]);
                $('#tipo').val(data[5]);

                $('#editForm').attr('action', '<?=ENV('APP_URL')?>carreras/'+data[0]);
                $('#modal_modificar_carrera').modal('show');

            });


            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();


                $('#deleteForm').attr('action', '<?=ENV('APP_URL')?>carreras/'+data[0]);
                $('#modal_eliminar_carrera').modal('show');

            }  );
            
        });

    </script>
</body>
@endsection

</html>
