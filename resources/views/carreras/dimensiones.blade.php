@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        @foreach ($carrera as $c)
        @endforeach

        <title>Dimensiones {{$c['nombre']}}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
@section('content')
<body >
        <div class="container-fluid">   
                

                <h4>
                    <a href="/carreras/"><img src="/images/back.png" alt="" srcset="" style="margin-top: 1%; margin-bottom: 1%;"></a> 
                </h4>
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
            <h3 class="mb-0 text-gray-800">Gestión de Dimensiones</h3>
            @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_dimension" style="margin-bottom: 1%; margin-top: 1%">
                        Agregar dimensión                 
                </button>
            @endif

                <table id="lista" class="table table-striped table-bordered" style="text-align: center" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                    <th style="display: none">ID </th>
                                    <th style="display: none">ID</th>
                                    <th style="width: 25%">Competencia⇵</th>
                                    <th style="width: 8%">Número/Orden⇵</th>
                                    <th style="width: 25%">Dimensión⇵</th>
                                    <th style="width: 15%">Fecha de creación⇵</th>
                                    <th style="width: 15%">Fecha de actualización⇵</th>
                                    <th style="width: 8%"></th>
                                </tr>
                        </thead>
                        
                        <tbody> 

                                @foreach ($dimension as $dim)
                                <tr>
                                    <td style="display: none">{{$dim['id']}}</td>
                                    <td style="display: none">{{$dim['idComp']}}</td>
                                    <td style="text-align: center">{{$dim['Orden_comp']}}. {{$dim['Descripcion']}}</td>
                                    <td style="text-align: center">{{$dim['Orden']}}</td>
                                    <td style="text-align: center">{{$dim['Descripcion_dimension']}}</td>
                                    <td style="text-align: center">{{$dim['created_at']}}</td>
                                    <td style="text-align: center">{{$dim['updated_at']}}</td>
                                    <td style="text-align: center">
                                        @if (Auth::user()->rol != 'Dirección de docencia')
                                            <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_dimension" class="edit"> </button>
                                            <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_dimension" class="delete"> </button>
                                        @endif
                                    </td>                  
                                </tr>
                                @endforeach
                                                      
                        </tbody>
                </table> 

                


        </div>


        <!-- MODALS DIMENSION -->

        <!-- Modal crear dimension   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_dimension" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/dimensiones" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar dimensión</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                                <label style="font-size: 20; font-weight: bold">Descripción de la dimension</label>
                                                <textarea class="form-control form-control-lg" name="desc_dimension" type="text"  style="color: black" placeholder="Ingrese la descripción de la dimension" rows="3" cols="50"  required></textarea>
                                                <span style="color: red">@error('desc_dimension')  Debe ingresar una descripción para la dimensión @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Número/Orden</label>
                                                <input class="form-control form-control-lg" name="orden_dimension" style="width:20%; color: black" type="number" min="0" max="100" required/>        
                                                <span style="color: red">@error('orden_dimension')  Debe ingresar un número de orden para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                                <label style="font-size: 20; font-weight: bold">Competencia asociada</label>
                                                <select class="form-select form-select-lg" name="refComp" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required> 
                                                    <option selected disabled="true" value="">Seleccione una competencia</option>
                                                    @foreach ($competencia as $comp) 
                                                    <option value="{{$comp['id']}}" required>{{$comp['Descripcion']}}</option>
                                                    @endforeach
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


        <!-- Modal modificar dimension   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_dimension" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "POST" action = "/carreras/{{$c['id']}}/dimensiones" class="form-group" id = "editForm">

                            @csrf
                            @method('PUT')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar dimensión</h1>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                            <label style="font-size: 20; font-weight: bold">Descripción de la dimension</label>
                                            <textarea class="form-control form-control-lg" name="desc_dimension" id="desc_dimension" type="text"  style="color: black" placeholder="Ingrese la descripción de la dimension" rows="3" cols="50"  required></textarea>
                                            <span style="color: red">@error('desc_dimension')  Debe ingresar una descripción para la dimensión @enderror</span>
                                        </div>

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Número/Orden</label>
                                                <input class="form-control form-control-lg" name="orden_dimension" id="orden_dimension" style="width:20%; color: black" type="number" min="0" max="100" required/>        
                                                <span style="color: red">@error('orden_dimension')  Debe ingresar un número de orden para la competencia  @enderror</span>
                                        </div>

                                        <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                            <label style="font-size: 20; font-weight: bold">Competencia asociada</label>
                                            <select class="form-select form-select-lg" name="refComp" id="refComp" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required> 
                                                <option selected disabled="true" value="">Seleccione una competencia</option>
                                                @foreach ($competencia as $comp) 
                                                <option value="{{$comp['id']}}" required>{{$comp['Descripcion']}}</option>
                                                @endforeach
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




        <!-- Modal eliminar dimension  -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_dimension" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "POST" action = "/carreras/{{$c['id']}}/dimensiones" class="form-group" id = "deleteForm">

                                @csrf
                                @method('DELETE')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar dimensión</h1>
                                    </div>
                                    <div class="modal-body" style="text-align: center">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar ésta dimensión? Se eliminarán todos los aprendizajes, saberes y módulos vinculados</p>
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




            //TABLA DE DIMENSIONES

            //modificar
            table.on('click', '.edit', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();
                console.log(data);


                $('#refComp').val(data[1]);

                $('#orden_dimension').val(data[3]);
                $('#desc_dimension').val(data[4]);

                $('#editForm').attr('action', '/carreras/{{$c['id']}}/dimensiones/'+data[0]);
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


                $('#deleteForm').attr('action', '/carreras/{{$c['id']}}/dimensiones/'+data[0]);
                $('#modal_eliminar_dimension').modal('show');

            }  );


            
        });

    </script>
</body>
@endsection

</html>
