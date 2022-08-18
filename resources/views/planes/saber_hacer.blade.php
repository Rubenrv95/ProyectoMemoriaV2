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
                        <h1 class="mb-0 text-gray-800">Saberes {{$p['Nombre']}} - {{$c['nombre']}} </h1>
                </div>

                <hr class="solid">

                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/malla"><button type="button" class="boton_gestionar">Malla Curricular</button></a> 

                <hr class="solid">

                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saberes"><button type="button" class="btn btn-secondary">Gestión de Saber Conocer</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saberes"><button type="button" class="btn btn-secondary">Gestión de Saber Hacer</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saberes"><button type="button" class="btn btn-secondary">Gestión de Saber Ser</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saberes"><button type="button" class="btn btn-secondary">Temporalización de Saberes</button></a> 

                <hr class="solid">

        </div>

        <div class="container-fluid" style="margin-top: 2%">   

                

                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_saber" style="margin-bottom: 10px;">
                        Agregar saber                   
                </button>

                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID <img src="/images/arrows.png" alt="" srcset=""> </th>
                                <th>Descripción <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Condicion <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Aprendizaje Asociado <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Fecha de Creación <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th style="width: 7%"></th>
                                </tr>
                        </thead>
                        
                        <tbody> 
                            @foreach ($saber as $s) 
                                <tr>
                                <td style="display: none">{{$s['id']}}</td>
                                <td>{{$s['Descripcion_saber']}}</td>
                                <td>{{$s['Condicion']}}</td>
                                <td>{{$s['Descripcion_aprendizaje']}}</td>
                                <td>{{$s['Fecha_creacion']}}</td>
                                <td>
                                    @if (Auth::user()->rol != 'Dirección de docencia')
                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_saber" class="edit"> </button>
                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_saber" class="delete"> </button>
                                    @endif
                                </td>
                                
                                </tr>
                            @endforeach

                        </tbody>
                </table> 


        </div>

        <!-- MODALS SABERES -->

        <!-- Modal crear saber   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_saber" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso/saberes" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar saber</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción del saber</label>
                                                <textarea class="form-control" name="desc_saber" type="text"  placeholder="Ingrese la descripción del saber" rows="3" cols="50" maxlength="200" required></textarea>
                                                <span style="color: red">@error('desc_saber')  Debe ingresar una descripción para el saber  @enderror</span>
                                            </div>


                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Aprendizaje asociado </label>
                                                <select class="form-select form-select-lg" name="refAprend" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    @foreach ($aprendizaje as $a)  
                                                    <option value="{{$a['id']}}">{{$a['Descripcion_aprendizaje']}}</option>
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


        <!-- Modal modificar saber   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_saber" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "POST" action = "" class="form-group" id = "editForm3">

                            @csrf
                            @method('PUT')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar saber </h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción de la competencia</label>
                                                <textarea class="form-control" name="desc_saber" id="desc_saber" type="text"  placeholder="Ingrese la descripción del saber" rows="3" cols="50" maxlength="200" required></textarea>
                                                <span style="color: red">@error('desc_saber')  Debe ingresar una descripción para el saber @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Tipo de Saber</label>
                                                <select class="form-select form-select-lg" name="tipo_saber" id="tipo_saber" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    <option selected value="Cognitivo">Cognitivo</option>
                                                    <option value="Actitudinal">Actitudinal</option>
                                                    <option value="Procedimental">Procedimental</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Aprendizaje asociado </label>
                                                <select class="form-select form-select-lg" name="refAprend" id ="refAprend" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>                 
                                                    @foreach ($aprendizaje as $a)  
                                                    <option value="{{$a['id']}}">{{$a['Descripcion_aprendizaje']}}</option>
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




        <!-- Modal eliminar saber    -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_saber" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "POST" action = "" class="form-group" id = "deleteForm3">

                                @csrf
                                @method('DELETE')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar saber </h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar éste saber?</p>
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


        <!--Terminan Modals Saberes -->




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

                $('#desc_competencia').val(data[1]);
                $('#tipo').val(data[2]);
                $('#nivel').val(data[3]);

                $('#editForm').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso/'+data[0]);
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


                $('#deleteForm').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso/'+data[0]);
                $('#modal_eliminar_competencia').modal('show');

            }  );
        });

    </script>
</body>
@endsection

</html>
