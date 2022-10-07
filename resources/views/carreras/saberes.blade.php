@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @foreach ($carrera as $c)
        @endforeach

        <title>Saberes {{$c['nombre']}}</title>
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
                        <h1 class="mb-0 text-gray-800">Saberes {{$c['nombre']}} </h1>
                </div>

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="/carreras/{{$c['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/modulos"><button type="button" class="boton_gestionar">Módulos</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="/carreras/{{$c['id']}}/saberes"><button type="button" class="btn btn-secondary">Gestión de Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/ver_saberes"><button type="button" class="btn btn-secondary">Visualización de Saberes</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

        </div>

        <div class="container-fluid" style="overflow-x:scroll; height: 92vh">   

            <h3 class="mb-0 text-gray-800">Gestión de Saberes</h3>

            @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_saber" style="margin-bottom: 1%; margin-top: 1%">
                        Agregar saber                   
                </button>
            @endif
                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead style="text-align: center">

                            <tr style="font-weight: bold; color: white">
                                <th rowspan="2"style="width: 10%; text-align: center">Competencia⇵</th>
                                <th rowspan="2"style="width: 10%; text-align: center">Dimensión⇵</th>
                                <th rowspan="2" style="width: 10%; text-align: center; display: none">id aprendizaje</th>
                                <th rowspan="2" style="width: 10%; text-align: center">Aprendizajes⇵</th>
                                <th colspan="16" style="text-align: center">Niveles</th>
                            </tr>
                            <tr style="font-weight: bold; color: white">
                                @for ($i = 1; $i <= 16; $i++)
                                    <th style="display: none"> id</th>
                                    <th style="display: none"> Descripcion saber</th>
                                    <th style="display: none"> Tipo</th>
                                    <th style="display: none"> Nivel</th>
                                    <th style="text-align: center; width: 1%">{{$i}}</th>
                                @endfor
                            </tr>

                        </thead>
                        
                        <tbody> 
                            @foreach ($saber as $s) 
                                <tr>
                                <td style="text-align: center">{{$s['OrdenComp']}}. {{$s['Descripcion']}}</td>
                                <td style="text-align: center">{{$s['OrdenDim']}}. {{$s['Descripcion_dimension']}}</td>
                                <td style="text-align: center; display: none">{{$s['idAprend']}}</td>
                                <td style="text-align: center">{{$s['Descripcion_aprendizaje']}}</td>

                                @for ($i = 1; $i <= 16; $i++)
                                    <td style="display: none">{{$s['id']}}</td>
                                    <td style="display: none">{{$s['Descripcion_saber']}}</td>
                                    <td style="display: none">{{$s['Tipo']}}</td>
                                    <td style="display: none">{{$s['Nivel']}}</td>
                                    <td style="text-align: center">
                                        @if ($s['Nivel'] == $i)
                                            @if (Auth::user()->rol != 'Dirección de docencia')
                                            <div class="dropdown-container" tabindex="-1" style="float:right;">
                                                <div class="three-dots"></div>
                                                <div class="dropdown dropdown-table">
                                                    <button type="button" id="mod"  data-bs-toggle="modal" data-bs-target="#modal_modificar_saber" class="edit"> </button>
                                                    <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_saber" class="delete"> </button>
                                                </div>
                                            </div>
                                            @endif         
                                            {{$s['Descripcion_saber']}} ({{$s['Tipo']}})  
                                        @endif      
                                    </td>
                                @endfor

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
                            <form action="/carreras/{{$c['id']}}/saberes" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar saber</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción del saber</label>
                                                <textarea class="form-control form-control-lg" name="desc-saber" type="text" style="color: black"  placeholder="Ingrese la descripción del saber" rows="3" cols="50" maxlength="200" required></textarea>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Tipo de Saber</label>
                                                <select class="form-select form-select-lg" name="tipo" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                        <option selected disabled="true" value="">Seleccione el tipo de saber</option>                                                    
                                                        <option value="Cognitivo">Cognitivo</option>
                                                        <option value="Procedimental">Procedimental</option>
                                                        <option value="Actitudinal">Actitudinal</option>
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Nivel</label>
                                                <select class="form-select form-select-lg" name="nivel" aria-label=".form-select-lg example" style="width:23%; margin-bottom: 20px; font-size: 18" required>
                                                        <option selected disabled="true" value="">Nivel</option>      
                                                        @for ($i = 1; $i <= 16; $i++)
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor                                              
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Aprendizaje asociado </label>
                                                <select class="form-select form-select-lg" name="refAprend" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione el aprendizaje</option>  
                                                    @foreach ($aprendizaje as $a)                                                      
                                                        <option value="{{$a['id']}}">{{$a['Descripcion_aprendizaje']}} ({{$a['Nivel_aprend']}})</option>
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
                    <div tabIndex="-1"  class="modal fade" id="modal_modificar_saber" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/saberes" method="POST" class="form-group" id = "editForm">
                            
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar saber</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción del saber</label>
                                                <textarea class="form-control form-control-lg" id="desc-saber" name="desc-saber" type="text" style="color: black"  placeholder="Ingrese la descripción del saber" rows="3" cols="50" maxlength="200"></textarea>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Tipo de Saber</label>
                                                <select class="form-select form-select-lg" id="tipo" name="tipo" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                        <option selected disabled="true" value="">Seleccione el tipo de saber</option>                                                    
                                                        <option value="Cognitivo">Cognitivo</option>
                                                        <option value="Procedimental">Procedimental</option>
                                                        <option value="Actitudinal">Actitudinal</option>
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Nivel</label>
                                                <select class="form-select form-select-lg" id="nivel" name="nivel" aria-label=".form-select-lg example" style="width:23%; margin-bottom: 20px; font-size: 18" required>
                                                        <option selected disabled="true" value="">Nivel</option>      
                                                        @for ($i = 1; $i <= 16; $i++)
                                                            <option value="{{$i}}">{{$i}}</option>
                                                        @endfor                                              
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Aprendizaje asociado </label>
                                                <select class="form-select form-select-lg" id="refAprend" name="refAprend" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione el aprendizaje</option>  
                                                    @foreach ($aprendizaje as $a)                                                      
                                                        <option value="{{$a['id']}}">{{$a['Descripcion_aprendizaje']}} ({{$a['Nivel_aprend']}})</option>
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

        <!-- Modal eliminar saber    -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_saber" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "POST" action = "" class="form-group" id = "deleteForm">

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


            table.on('click', '.edit', function() {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();
                console.log(data);

                $('#desc-saber').val(data[5]);
                $('#tipo').val(data[6]);
                $('#nivel').val(data[7]);
                $('#refAprend').val(data[2]);

                $('#editForm').attr('action', '/carreras/{{$c['id']}}/saberes/'+data[4]);
                $('#modal_modificar_saber').modal('show');
            })

            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteForm').attr('action', '/carreras/{{$c['id']}}/saberes/'+data[4]);
                $('#modal_eliminar_saber').modal('show');

            }  );
        });

    
    </script>

</body>
@endsection

</html>