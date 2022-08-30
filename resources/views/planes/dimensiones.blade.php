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

        <title>Dimensiones {{$p['Nombre']}} - {{$c['nombre']}}</title>
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
                        <h1 class="mb-0 text-gray-800">Dimensiones {{$p['Nombre']}} - {{$c['nombre']}} </h1>
                </div>

                <hr class="solid">
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saber_conocer"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/malla"><button type="button" class="boton_gestionar">Módulos</button></a> 

                <hr class="solid">

                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="btn btn-secondary">Gestión de Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/dimensiones"><button type="button" class="btn btn-secondary">Gestión de Dimensiones</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/tempo_competencias"><button type="button" class="btn btn-secondary">Temporalización de Competencias</button></a> 

                <hr class="solid">

        </div>
        <div class="container-fluid">   
            <h3 class="mb-0 text-gray-800">Gestión de Dimensiones</h3>
            @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_dimension" style="margin-bottom: 1%; margin-top: 1%">
                        Agregar dimensión                 
                </button>
            @endif

                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                    <th rowspan="2">Competencia<img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th rowspan="2">Dimensión<img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th colspan="4">Niveles</th>
                                    <th rowspan="2">Fecha de creación <img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th rowspan="2">Fecha de actualización <img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th rowspan="2"></th>
                                </tr>
                                <tr style="font-weight: bold; color: white">
                                    <th>Básico <img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th>En desarrollo <img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th>Logrado <img src="/images/arrows.png" alt="" srcset=""></th>
                                    <th>Especialización <img src="/images/arrows.png" alt="" srcset=""></th>
                                </tr>
                        </thead>
                        
                        <tbody> 

                                @foreach ($dimension as $dim)
                                <tr>
                                    <td>{{$dim['Orden']}}. {{$dim['Descripcion']}}</td>
                                    <td>{{$dim['Descripcion_dimension']}}</td>
                                    <td>{{$dim['Basico']}}</td>
                                    <td>{{$dim['En_desarrollo']}}</td>
                                    <td>{{$dim['Logrado']}}</td>
                                    <td>{{$dim['Especializacion']}}</td>
                                    <td>{{$dim['created_at']}}</td>
                                    <td>{{$dim['updated_at']}}</td>
                                    <td>
                                        @if (Auth::user()->rol != 'Dirección de docencia')
                                            <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_competencia" class="edit"> </button>
                                            <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_competencia" class="delete"> </button>
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
                            <form action="/carreras/{{$c['id']}}/{{$p['id']}}/dimensiones" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar dimensión</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                                <label style="font-size: 20">Descripción de la dimension</label>
                                                <textarea class="form-control" name="desc_dimension" type="text"  placeholder="Ingrese la descripción de la dimension" rows="3" cols="50"  required></textarea>
                                                <span style="color: red">@error('desc_dimension')  Debe ingresar una descripción para la dimensión @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                                <label style="font-size: 20">Competencia asociada</label>
                                                <select class="form-select form-select-lg" name="refComp" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required> 
                                                    @foreach ($competencia as $comp) 
                                                    <option value="{{$comp['id']}}">{{$comp['Descripcion']}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                                <label style="font-size: 20">Nivel básico</label>
                                                <input class="form-control form-control-lg" name="basico_dimension" style="width:100%"  placeholder="Ingrese el nivel básico de la dimensión" maxlength="2000" required/>        
                                                <span style="color: red">@error('dimension_competencia')  Debe ingresar una descripción para el nivel básico  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                                <label style="font-size: 20">Nivel en desarrollo</label>
                                                <input class="form-control form-control-lg" name="desarrollo_dimension" style="width:100%"  placeholder="Ingrese el nivel en desarrollo de la dimensión" maxlength="2000" required/>        
                                                <span style="color: red">@error('dimension_competencia')  Debe ingresar una descripción para el nivel en desarrollo   @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                                <label style="font-size: 20">Nivel logrado</label>
                                                <input class="form-control form-control-lg" name="logrado_dimension" style="width:100%"  placeholder="Ingrese el nivel logrado de la dimensión" maxlength="2000" required/>        
                                                <span style="color: red">@error('dimension_competencia')  Debe ingresar una descripción para el nivel logrado  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 1%">
                                                <label style="font-size: 20">Nivel especializado (opcional)</label>
                                                <input class="form-control form-control-lg" name="especializado_dimension" style="width:100%"  placeholder="Ingrese el nivel de especialización de la dimensión" maxlength="2000"/>        
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

                            <form method = "POST" action = "/carreras/{{$c['id']}}/{{$p['id']}}/dimensiones" class="form-group" id = "editForm">

                            @csrf
                            @method('PUT')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar dimensión</h1>
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

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Dimensiones</label>
                                                <input class="form-control form-control-lg" name="dimension_competencia" id="dimension_competencia" style="width:100%"  placeholder="Ingrese una dimensión de la competencia" maxlength="40000" required/>        
                                                <span style="color: red">@error('dimension_competencia')  Debe ingresar al menos una dimensión para la competencia  @enderror</span>
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
                            <form method = "POST" action = "/carreras/{{$c['id']}}/{{$p['id']}}/dimensiones" class="form-group" id = "deleteForm">

                                @csrf
                                @method('DELETE')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar competencia</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar ésta dimensión?</p>
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
                "order": [[ 0, "asc" ]]
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
                $('#dimension_competencia').val(data[3]);

                $('#editForm').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/competencias/'+data[0]);
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


                $('#deleteForm').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/competencias/'+data[0]);
                $('#modal_eliminar_dimension').modal('show');

            }  );


            
        });

    </script>
</body>
@endsection

</html>
