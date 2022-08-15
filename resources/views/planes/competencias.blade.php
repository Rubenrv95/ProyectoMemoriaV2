@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        @foreach ($plan as $p)
        @endforeach

        @foreach ($carrera as $c)
        @endforeach

        <title>Perfil de Egreso {{$p['Nombre']}} - {{$c['nombre']}}</title>
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
                        <h1 class="mb-0 text-gray-800">Competencias {{$p['Nombre']}} - {{$c['nombre']}} </h1>
                </div>

                <hr class="solid">
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/malla"><button type="button" class="boton_gestionar">Malla Curricular</button></a> 

                <hr class="solid">

                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="btn btn-secondary">Gestión de Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="btn btn-secondary">Temporalización de Competencias</button></a> 

                <hr class="solid">

        </div>
        <div class="container-fluid" style="margin-top: 2%">   
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_competencia" style="margin-bottom: 10px;">
                        Agregar competencia                   
                </button>

                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID <img src="/images/arrows.png" alt="" srcset=""> </th>
                                <th>Nombre<img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Descripción<img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Nivel Básico <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Nivel Intermedio <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Nivel Avanzado <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Orden <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Condicion <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Fecha de creación <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th style="width: 150px"></th>
                                </tr>
                        </thead>
                        
                        <tbody>
                        
                            @foreach ($competencia as $comp)   
                                <tr>
                                <td style="display: none">{{$comp['id']}}</td>
                                <td>{{$comp['Nombre']}}</td>
                                <td>{{$comp['Descripcion']}}</td>
                                <td>{{$comp['Nivel_basico']}}</td>
                                <td>{{$comp['Nivel_intermedio']}}</td>
                                <td>{{$comp['Nivel_avanzado']}}</td>
                                <td>{{$comp['Orden']}}</td>
                                <td>{{$comp['Condicion']}}</td>
                                <td>{{$comp['Fecha_creacion']}}</td>
                                <td>
                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_competencia" class="edit"> </button>
                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_competencia" class="delete"> </button>
                                </td>
                                
                                </tr>
                            @endforeach   
                        
                        </tbody>
                </table> 

                


        </div>


        <!-- MODALS COMPETENCIA -->

        <!-- Modal crear competencia   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_competencia" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/{{$p['id']}}/competencias" method="POST" class="form-group">
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

                            <form method = "POST" action = "/carreras/{{$c['id']}}/{{$p['id']}}/competencias" class="form-group" id = "editForm">

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
                            <form method = "POST" action = "/carreras/{{$c['id']}}/{{$p['id']}}/competencias" class="form-group" id = "deleteForm">

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
                "order": [[ 1, "asc" ]]
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

                $('#nombre_competencia').val(data[1]);
                $('#desc_competencia').val(data[2]);
                $('#basico_competencia').val(data[3]);
                $('#intermedio_competencia').val(data[4]);
                $('#avanzado_competencia').val(data[5]);

                $('#editForm').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/competencias/'+data[0]);
                $('#modal_modificar_competencia').modal('show');

            });


            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteForm').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/competencias/'+data[0]);
                $('#modal_eliminar_competencia').modal('show');

            }  );


            
        });

    </script>
</body>
@endsection

</html>
