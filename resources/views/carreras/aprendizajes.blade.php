@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @foreach ($carrera as $c)
        @endforeach

        <title>Aprendizajes {{$c['nombre']}}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
@section('content')
<body >
        <div class="container-fluid">   
                
                <a href="/carreras/{{$c['id']}}"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Aprendizajes {{$c['nombre']}} </h1>
                </div>

                <hr class="solid">

                <a href="/carreras/{{$c['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/saber_conocer"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/malla"><button type="button" class="boton_gestionar">Módulos</button></a> 

                <hr class="solid">

                <a href="/carreras/{{$c['id']}}/aprendizajes"><button type="button" class="btn btn-secondary">Gestión de Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/tempo_aprendizajes"><button type="button" class="btn btn-secondary">Temporalización de Aprendizajes</button></a> 

                <hr class="solid">

        </div>

        <div class="container-fluid">   
            <h3 class="mb-0 text-gray-800">Gestión de Aprendizajes</h3>
            @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_aprendizaje" style="margin-bottom: 1%; margin-top: 1%">
                        Agregar aprendizaje                    
                </button>
            @endif
            <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                    <th rowspan="2" style="display: none">ID  </th>
                                    <th rowspan="2" style="display: none">ID</th>
                                    <th rowspan="2">Competencia⇵</th>
                                    <th rowspan="2">Dimensión⇵</th>
                                    <th colspan="4">Aprendizajes</th>
                                    <th rowspan="2">Fecha de creación⇵</th>
                                    <th rowspan="2">Fecha de actualización⇵</th>
                                    <th rowspan="2"></th>
                                </tr>
                                <tr style="font-weight: bold; color: white">
                                    <th>Inicial⇵</th>
                                    <th>En desarrollo⇵</th>
                                    <th>Logrado⇵</th>
                                    <th>Especialización⇵</th>
                                </tr>
                        </thead>
                        
                        <tbody> 

                                
                                <tr>
                                    <td style="display: none"></td>
                                    <td style="display: none"></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        @if (Auth::user()->rol != 'Dirección de docencia')
                                            <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_dimension" class="edit"> </button>
                                            <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_dimension" class="delete"> </button>
                                        @endif
                                    </td>                  
                                </tr>
                                
                                                      
                        </tbody>
            </table> 


        </div>

        <!--MODALS APRENDIZAJE -->

        <!-- Modal crear aprendizaje   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_aprendizaje" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/aprendizajes" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción del aprendizaje</label>
                                                <textarea class="form-control" name="desc_aprendizaje" type="text" style="color: black" placeholder="Ingrese la descripción del aprendizaje" rows="3" cols="50" maxlength="200" required></textarea>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Competencia asociada</label>
                                                <select class="form-select form-select-lg" name="refComp" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required> 
                                                    <option selected disabled="true" value="">Seleccione una competencia</option>
                                                    @foreach ($competencia as $comp) 
                                                    <option value="{{$comp['id']}}">{{$comp['Descripcion']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Dimensión asociada</label>
                                                <select class="form-select form-select-lg" name="refComp" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required> 
                                                    <option selected disabled="true" value="">Seleccione una competencia</option>
                                                    
                                                    <option value="">Dimension 1</option>
                                                    <option value="">Dimension 2</option>
                                                    
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


        <!-- Modal modificar aprendizaje   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_aprendizaje" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "editForm">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción del aprendizaje </label>
                                                <textarea class="form-control" name="desc_aprendizaje" id="desc_aprendizaje" type="text" style="color: black"  placeholder="Ingrese la descripción del aprendizaje" rows="3" cols="50" maxlength="200" required></textarea>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Competencia asociada</label>
                                                <select class="form-select form-select-lg" name="refComp" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required> 
                                                    <option selected disabled="true" value="">Seleccione una competencia</option>
                                                    @foreach ($competencia as $comp) 
                                                    <option value="{{$comp['id']}}">{{$comp['Descripcion']}}</option>
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




        <!-- Modal eliminar aprendizaje   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_aprendizaje" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "deleteForm">

                                {{ csrf_field() }}
                                {{ method_field('DELETE')}}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar éste aprendizaje? Se eliminarán todos los saberes vinculados.</p>
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


            //TABLA DE COMPETENCIAS

            //modificar
            table.on('click', '.edit', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();
                console.log(data);

                $('#desc_aprendizaje').val(data[1]);
                $('#refComp').val(data[4]);

                $('#editForm').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[0]);
                $('#modal_modificar_aprendizaje').modal('show');

            });


            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteForm').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[0]);
                $('#modal_eliminar_aprendizaje').modal('show');

            }  );


        });

    </script>
</body>
@endsection

</html>
