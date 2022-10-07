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

                <hr class="solid" style="border-width: 1px; background-color: black">
                <a href="/carreras/{{$c['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/modulos"><button type="button" class="boton_gestionar">Módulos</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="/carreras/{{$c['id']}}/aprendizajes"><button type="button" class="btn btn-secondary">Gestión de Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/tempo_aprendizajes"><button type="button" class="btn btn-secondary">Temporalización de Aprendizajes</button></a> 

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
                            @for ($i = 1; $i <= 16; $i++)
                                <th style="text-align: center">Nivel {{$i}}</th>
                            @endfor
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($aprendizaje as $a)
                        <tr>
                            <td>{{$a['Orden']}}. {{$a['Descripcion']}}</td>
                            <td>{{$a['Nivel_aprend']}}</td>
                            <td>{{$a['Descripcion_aprendizaje']}}</td>
                            <td>{{$a['Descripcion_dimension']}}</td>

                            @for ($i = 1; $i <= 16; $i++)
                            <td> <input type="checkbox" style="width: 30px; height: 30px; text-align: center"></td>
                            @endfor
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                    
                <div class="col text-center">
                        <button type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
               

        </div>


        <!-- MODALS COMPETENCIA -->

        <!-- Modal crear competencia   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_competencia" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/competencias" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar competencia</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nombre de la competencia</label>
                                                <input class="form-control form-control-lg" name="nombre_competencia" style="width:100%"  placeholder="Ingrese el nombre de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar un nombre para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción de la competencia</label>
                                                <textarea class="form-control" name="desc_competencia" type="text"  placeholder="Ingrese la descripción de la competencia" rows="3" cols="50"  required></textarea>
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar una descripción para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nivel Básico</label>
                                                <input class="form-control form-control-lg" name="basico_competencia" style="width:100%"  placeholder="Ingrese el nivel básico de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar un nombre para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nivel Intermedio</label>
                                                <input class="form-control form-control-lg" name="intermedio_competencia" style="width:100%"  placeholder="Ingrese el nivel intermedio de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar un nombre para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nivel Avanzado</label>
                                                <input class="form-control form-control-lg" name="avanzado_competencia" style="width:100%"  placeholder="Ingrese el nivel avanzado de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar un nombre para la competencia  @enderror</span>
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


        <!-- Modal modificar competencia   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_competencia" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "POST" action = "/carreras/{{$c['id']}}/competencias" class="form-group" id = "editForm">

                            @csrf
                            @method('PUT')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar competencia</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nombre de la competencia</label>
                                                <input class="form-control form-control-lg" id="nombre_competencia" name="nombre_competencia" style="width:100%"  placeholder="Ingrese el nombre de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar un nombre para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción de la competencia</label>
                                                <textarea class="form-control" id="desc_competencia" name="desc_competencia" type="text"  placeholder="Ingrese la descripción de la competencia" rows="3" cols="50"  required></textarea>
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar una descripción para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nivel Básico</label>
                                                <input class="form-control form-control-lg" id="basico_competencia" name="basico_competencia" style="width:100%"  placeholder="Ingrese el nivel básico de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar un nombre para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nivel Intermedio</label>
                                                <input class="form-control form-control-lg" id="intermedio_competencia" name="intermedio_competencia" style="width:100%"  placeholder="Ingrese el nivel intermedio de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar un nombre para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nivel Avanzado</label>
                                                <input class="form-control form-control-lg" id="avanzado_competencia" name="avanzado_competencia" style="width:100%"  placeholder="Ingrese el nivel avanzado de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar un nombre para la competencia  @enderror</span>
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




        <!-- Modal eliminar competencia   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_competencia" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "POST" action = "/carreras/{{$c['id']}}/competencias" class="form-group" id = "deleteForm">

                                @csrf
                                @method('DELETE')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar competencia</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar ésta competencia? Se eliminarán todos los aprendizajes y saberes vinculados.</p>
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

            
        });

    </script>
</body>
@endsection

</html>
