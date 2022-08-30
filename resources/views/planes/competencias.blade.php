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

        <title>Competencias {{$p['Nombre']}} - {{$c['nombre']}}</title>
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

                <hr class="solid" style="border-width: 1px; background-color: black">
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saber_conocer"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/malla"><button type="button" class="boton_gestionar">Módulos</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="btn btn-secondary">Gestión de Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/dimensiones"><button type="button" class="btn btn-secondary">Gestión de Dimensiones</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/tempo_competencias"><button type="button" class="btn btn-secondary">Temporalización de Competencias</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

        </div>
        <div class="container-fluid">   
            <h3 class="mb-0 text-gray-800">Gestión de Competencias</h3>
            @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_competencia" style="margin-bottom: 1%; margin-top: 1%">
                        Agregar competencia                   
                </button>
            @endif

                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                    <th style="display: none">ID <img src="/images/arrows.png" alt="" srcset=""> </th>
                                    <th>Número<img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th>Descripción<img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th >Fecha de creación <img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th>Fecha de actualización <img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th></th>
                                </tr>
                        </thead>
                        
                        <tbody>
                        
                            @foreach ($competencia as $comp)   
                                <tr>
                                    <td style="display: none">{{$comp['id']}}</td>
                                    <td rowspan="1">{{$comp['Orden']}}</td>
                                    <td rowspan="1">{{$comp['Descripcion']}}</td>
                                    <td rowspan="1">{{$comp['Fecha_creacion']}}</td>
                                    <td>{{$comp['updated_at']}}</td>
                                    <td rowspan="1">
                                        @if (Auth::user()->rol != 'Dirección de docencia')
                                            <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_competencia" class="edit"> </button>
                                            <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_competencia" class="delete"> </button>
                                        @endif
                                    </td>                  
                                </tr>
                                
                                <!--
                                <tr>
                                    <td rowspan="1">Otra dimension</td>     
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td rowspan="1">Dimension tercera</td>    
                                    <td></td>
                                    <td></td>
                                    <td></td>    
                                </tr> -->
                            @endforeach   


                            <!--
                            <table>
                                <tr id="row1">
                                    <td>a
                                    </td>
                                    <td>b
                                    </td>
                                    <td>c
                                    </td>
                                </tr>
                                <tr id="row2">
                                    <td>a2
                                    </td>
                                    <td>b2
                                    </td>
                                    <td>c2
                                    </td>
                                </tr>
                            </table>
                            <button id="b1">click here</button> -->

                        
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
                                                <label style="font-size: 20">Descripción de la competencia</label>
                                                <textarea class="form-control" name="desc_competencia" type="text"  placeholder="Ingrese la descripción de la competencia" rows="3" cols="50"  required></textarea>
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar una descripción para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Número/Orden</label>
                                                <input class="form-control form-control-lg" name="orden_competencia" style="width:20%" type="number"  min="0" max="100" required/>        
                                                <span style="color: red">@error('orden_competencia')  Debe ingresar un número de orden para la competencia  @enderror</span>
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
                                                <label style="font-size: 20">Descripción de la competencia</label>
                                                <textarea class="form-control" name="desc_competencia" id="desc_competencia" type="text"  placeholder="Ingrese la descripción de la competencia" rows="3" cols="50"  required></textarea>
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar una descripción para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Número/Orden</label>
                                                <input class="form-control form-control-lg" name="orden_competencia" id="orden_competencia" style="width:20%" type="number" min="0" max="100" required/>        
                                                <span style="color: red">@error('orden_competencia')  Debe ingresar un número de orden para la competencia  @enderror</span>
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
        $(document).ready(function(){
            $('#b1').on('click',function(){
                var v=$('</tr><tr id="row11" colspan=3><td>text</td>'); 
                $('#row1').after(v);
            });
        });
    </script>
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

                $('#desc_competencia').val(data[2]);
                $('#orden_competencia').val(data[1]);

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
