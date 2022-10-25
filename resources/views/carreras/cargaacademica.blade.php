@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        @foreach ($carrera as $c)
        @endforeach

        <title>Carga académica {{$c['nombre']}}</title>
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
        <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
@section('content')
<body >
        <div class="container-fluid">   
                
                <a href="/carreras"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Módulos {{$c['nombre']}} </h1>
                </div>

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="/carreras/{{$c['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/modulos"><button type="button" class="boton_gestionar">Módulos</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

                <a href="/carreras/{{$c['id']}}/modulos"><button type="button" class="btn btn-secondary">Propuesta de Módulos</button></a> 
                <a href="/carreras/{{$c['id']}}/carga_academica"><button type="button" class="btn btn-secondary">Carga Académica</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

        </div>

        <div class="container-fluid" style="overflow-x:scroll; height: 92vh">   

            <h3 class="mb-0 text-gray-800">Carga académica</h3>

            @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_modulo" style="margin-bottom: 1%; margin-top: 1%">
                        Agregar módulo                 
                </button>
            @endif
                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead style="text-align: center">

                            <tr style="font-weight: bold; color: white">
                                <th rowspan="2"style="text-align: center; display: none">id⇵</th>
                                <th rowspan="2"style="text-align: center">Semestre⇵</th>
                                <th rowspan="2"style="text-align: center; display: none">id prop⇵</th>
                                <th rowspan="2"style="text-align: center">Módulo⇵</th>
                                <th rowspan="2"style="text-align: center">Tipo Curso⇵</th>
                                <th rowspan="2"style="text-align: center">Requisitos⇵</th>
                                <th rowspan="2"style="text-align: center;">Clases⇵</th>
                                <th rowspan="2"style="text-align: center;">Seminario⇵</th>
                                <th rowspan="2" style="text-align: center;">Ayudantias⇵</th>
                                <th colspan="3">Actividades Prácticas, de Laboratorio</th>
                                <th colspan="2">Actividades Clínicas o terreno</th>
                                <th colspan="2">Trabajo Autónomo</th>
                                <th rowspan="2" style="text-align: center;">Horas semanales⇵</th>
                                <th rowspan="2" style="text-align: center;">Total horas del módulo⇵</th>
                                <th rowspan="2" style="text-align: center;">SCT-Chile⇵</th>
                                <th rowspan="2" style="text-align: center;"></th>
                                
                            </tr>

                            <tr style="font-weight: bold; color: white">
                                <th style="text-align: center;">AP⇵</th>
                                <th style="text-align: center;">LAB⇵</th>
                                <th style="text-align: center;">TALL⇵</th>
                                <th style="text-align: center;">AC⇵</th>
                                <th style="text-align: center;">TE⇵</th>
                                <th style="text-align: center;">Tareas⇵</th>
                                <th style="text-align: center;">Estudio⇵</th>
                            </tr>

                        </thead>
                        
                        <tbody> 
                            
                            @foreach ($modulo as $m)
                            <tr>     
                                <td style="display: none">{{$m['id']}}</td>                                
                                <td style="text-align: center">{{$m['Semestre']}}</td>
                                <td style="display: none">{{$m['idprop']}}</td>     
                                <td style="text-align: center">{{$m['Nombre_modulo']}}</td>
                                <td style="text-align: center">{{$m['Tipo']}}</td>
                                <td style="text-align: center"><button type="button" id="info" class="info_req" data-url="{{ route('carga_academica.show_requisitos', [ $c['id'] , $m['id'] ]) }}"> </button></td>     
                                <td style="text-align: center">
                                    @if ($m['Clases'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>

                                <td style="text-align: center">
                                    @if ($m['Seminario'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">
                                    @if ($m['Ayudantias'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">
                                    @if ($m['Actividades_practicas'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">
                                    @if ($m['Laboratorios'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">
                                    @if ($m['Talleres'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">
                                    @if ($m['Actividades_clinicas'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">
                                    @if ($m['Actividades_terreno'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">
                                    @if ($m['Tareas'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">
                                    @if ($m['Estudios'] == 1)
                                        SI
                                    @else
                                        NO
                                    @endif                          
                                </td>
                                <td style="text-align: center">{{$m['Horas_semanales']}}</td>
                                <td style="text-align: center">{{$m['Horas_totales']}}</td>
                                <td style="text-align: center">{{$m['Creditos']}}</td>
                                <td style="text-align: center">
                                    @if (Auth::user()->rol != 'Dirección de docencia')
                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_modulo" class="edit"> </button>
                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_modulo" class="delete"> </button>
                                    @endif
                                </td>
                            </tr>

                            @endforeach
                        </tbody>
                </table> 


        </div>

        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_requisitos" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <span id="titulo_modulo" style="margin: auto; text-align: center"></span>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group" style="margin: auto; margin-bottom: 20px; text-align: center">
                                            <span id="modulo_req"></span>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cerrar</button>
                                    </div> 
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- MODALS PROPUESTA DE MÓDULO -->

        <!-- Modal crear módulo   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_modulo" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/carga_academica" method="POST" class="form-group" name="crear_modulo" id="crear_modulo">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto">Agregar módulo</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Nombre del módulo</label>
                                                <select class="form-select form-select-lg" name="modulo" aria-label=".form-select-lg example" style="width:90%; margin-bottom: 20px; font-size: 18; color: black" required>
                                                        <option selected disabled="true" value="">Seleccionar propuesta de módulo</option>      
                                                        @foreach ($propuestas as $p)
                                                            <option value="{{$p['id']}}">{{$p['Nombre_modulo']}}</option>
                                                        @endforeach                                         
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20; font-weight: bold">Tipo de Curso</label>
                                                <select class="form-select form-select-lg" name="curso" aria-label=".form-select-lg example" style="margin-bottom: 20px; font-size: 18; color: black" required>
                                                        <option selected disabled="true" value="">Tipo de curso</option>      
                                                        <option value="FB">Formación Básica (FB)</option>  
                                                        <option value="FF">Formación Fundamental (FF)</option> 
                                                        <option value="FD">Formación Disciplinar (FD)</option>          
                                                        <option value="MIC">Módulo integrador de competencias (MIC)</option>    
                                                        <option value="DIC">Desempeño integrado de competencias (DIC)</option>                                  
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="clases" >
                                                <label style="font-size: 14; color: black">Clases</label> 
                                                <input class="form-check-input" type="checkbox" value="1"name="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Seminario</label>                                         
                                            </div>

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="practicas" >
                                                <label style="font-size: 14; color: black">Actividades prácticas</label> 
                                                <input class="form-check-input" type="checkbox" value="1" name="labs" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Laboratorio</label>  
                                                <input class="form-check-input" type="checkbox" value="1" name="talleres" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Talleres</label>                                        
                                            </div>

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="clinicas">
                                                <label style="font-size: 14; color: black">Actividades clínicas</label> 
                                                <input class="form-check-input" type="checkbox" value="1" name="terreno" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Actividades de terreno</label>                                       
                                            </div>

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="ayudantias" >
                                                <label style="font-size: 14; color: black">Ayudantías</label> 
                                                <input class="form-check-input" type="checkbox" value="1" name="tareas" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Tareas</label>          
                                                <input class="form-check-input" type="checkbox" value="1" name="estudio" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Estudio</label>                                 
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Horas semanales</label>
                                                <input class="form-control form-control-lg" name="horas_semanales" style="width:20%; color: black" type="number"  min="0" max="100" required/>        
                                                <span style="color: red">@error('orden_competencia')  Debe ingresar un número de orden para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Horas totales</label>
                                                <input class="form-control form-control-lg" name="horas_totales" style="width:20%; color: black" type="number"  min="0" max="999" required/>        
                                                <span style="color: red">@error('orden_competencia')  Debe ingresar un número de orden para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">SCT-Chile</label>
                                                <input class="form-control form-control-lg" name="creditos" style="width:20%; color: black" type="number"  min="0" max="100" required/>        
                                                <span style="color: red">@error('orden_competencia')  Debe ingresar un número de orden para la competencia  @enderror</span>
                                            </div>

                                            <div id="dynamicAdd" class="form-group" style="margin: auto">
                                                <label style="font-size: 20; font-weight: bold">Requisitos <button type="button" name="add" id="add" class="btn btn-info">+</button></label> 

                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="submit" id="submit"> Guardar</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button"> Cancelar</button>
                                    </div> 
                                
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal modificar módulo   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_modulo" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "POST" action = "/carreras/{{$c['id']}}/modulos" class="form-group" id = "editForm">

                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto">Modificar módulo</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Nombre del módulo</label>
                                                <select class="form-select form-select-lg" name="modulo" id="modulo" aria-label=".form-select-lg example" style="width:90%; margin-bottom: 20px; font-size: 18; color: black" required>
                                                        <option selected disabled="true" value="">Seleccionar propuesta de módulo</option>      
                                                        @foreach ($propuestas as $p)
                                                            <option value="{{$p['id']}}">{{$p['Nombre_modulo']}}</option>
                                                        @endforeach                                         
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20; font-weight: bold">Tipo de Curso</label>
                                                <select class="form-select form-select-lg" name="curso" id="curso" aria-label=".form-select-lg example" style="margin-bottom: 20px; font-size: 18; color: black" required>
                                                        <option selected disabled="true" value="">Tipo de curso</option>      
                                                        <option value="FB">Formación Básica (FB)</option>  
                                                        <option value="FF">Formación Fundamental (FF)</option> 
                                                        <option value="FD">Formación Disciplinar (FD)</option>          
                                                        <option value="MIC">Módulo integrador de competencias (MIC)</option>    
                                                        <option value="DIC">Desempeño integrado de competencias (DIC)</option>                                  
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="clases" id="clases">
                                                <label style="font-size: 14; color: black">Clases</label> 
                                                <input class="form-check-input" type="checkbox" value="1" name="seminario" id="seminario" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Seminario</label>                                         
                                            </div>

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="practicas" id="practicas">
                                                <label style="font-size: 14; color: black">Actividades prácticas</label> 
                                                <input class="form-check-input" type="checkbox" value="1" name="labs" id="labs" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Laboratorio</label>  
                                                <input class="form-check-input" type="checkbox" value="1" name="talleres" id="talleres" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Talleres</label>                                        
                                            </div>

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="clinicas" id="clinicas">
                                                <label style="font-size: 14; color: black">Actividades clínicas</label> 
                                                <input class="form-check-input" type="checkbox" value="1" name="terreno" id="terreno" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Actividades de terreno</label>                                       
                                            </div>

                                            <div class="form-group" style="margin-left: 5%">
                                                <input class="form-check-input" type="checkbox" value="1" name="ayudantias" id="ayudantias">
                                                <label style="font-size: 14; color: black">Ayudantías</label> 
                                                <input class="form-check-input" type="checkbox" value="1" name="tareas" id="tareas" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Tareas</label>          
                                                <input class="form-check-input" type="checkbox" value="1" name="estudio" id="estudio" style="margin-left: 2%" >
                                                <label style="font-size: 14; color: black; margin-left: 7%">Estudio</label>                                 
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Horas semanales</label>
                                                <input class="form-control form-control-lg" name="horas_semanales" id="horas_semanales" style="width:20%; color: black" type="number"  min="0" max="100" required/>        
                                                <span style="color: red">@error('orden_competencia')  Debe ingresar un número de orden para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Horas totales</label>
                                                <input class="form-control form-control-lg" name="horas_totales" id="horas_totales" style="width:20%; color: black" type="number"  min="0" max="999" required/>        
                                                <span style="color: red">@error('orden_competencia')  Debe ingresar un número de orden para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">SCT-Chile</label>
                                                <input class="form-control form-control-lg" name="creditos" id="creditos" style="width:20%; color: black" type="number"  min="0" max="100" required/>        
                                                <span style="color: red">@error('orden_competencia')  Debe ingresar un número de orden para la competencia  @enderror</span>
                                            </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit" name="submit" id="submit"> Guardar</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button"> Cancelar</button>
                                    </div> 

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <!-- Modal eliminar módulo    -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_modulo" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "POST" action = "" class="form-group" id = "deleteForm">

                                @csrf
                                @method('DELETE')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto">Eliminar módulo</h1>
                                    </div>
                                    <div class="modal-body" style="text-align: center">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar éste módulo de la carga académica?</p>
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


        <!--Terminan Modals módulos -->




    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>    
        $(document).ready(function() {

            $('#lista').on('click', '.info_req', function () {


                var reqURL = $(this).data('url');

                $.get(reqURL, function (data) {

                    var lista = "";

                    if(!data[0].length){
                        lista =    '<h6 style="color:black"> Éste módulo no tiene prerrequisitos </h6>';     
                    }

                    else {
                        for (const prop in data[0]) {         
                            lista +=    '<li style="color: black">' + data[0][prop]['Nombre_modulo'] + '</li>';        
                        } 
                    }
               
                    document.getElementById("titulo_modulo").innerHTML = '<h1 class="justify-content-center">Prerrequisitos de ' + data[1][0]['Nombre_modulo'] + '</h1>';

                    document.getElementById("modulo_req").innerHTML = lista;

                    


                    $('#modal_requisitos').modal('show');

                })

            });


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

            //TABLA DE MODULOS

            //modificar
            table.on('click', '.edit', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();
                console.log(data);
                

                $('#modulo').val(data[2]);
                $('#curso').val(data[4]);
                $('#horas_semanales').val(data[16]);
                $('#horas_totales').val(data[17]);
                $('#creditos').val(data[18]);

                if (data[6] == "SI") {
                    document.getElementById("clases").checked = true;
                }

                if (data[7] == "SI") {
                    document.getElementById("seminario").checked = true;
                }

                if (data[8] == "SI") {
                    document.getElementById("ayudantias").checked = true;
                }

                if (data[9] == "SI") {
                    document.getElementById("practicas").checked = true;
                }

                if (data[10] == "SI") {
                    document.getElementById("labs").checked = true;
                }

                if (data[11] == "SI") {
                    document.getElementById("talleres").checked = true;
                }

                if (data[12] == "SI") {
                    document.getElementById("clinicas").checked = true;
                }

                if (data[13] == "SI") {
                    document.getElementById("terreno").checked = true;
                }

                if (data[14] == "SI") {
                    document.getElementById("tareas").checked = true;
                }

                if (data[15] == "SI") {
                    document.getElementById("estudio").checked = true;
                }

                $('#editForm').attr('action', '/carreras/{{$c['id']}}/carga_academica/'+data[0]);
                $('#modal_modificar_modulo').modal('show');

            });


            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteForm').attr('action', '/carreras/{{$c['id']}}/carga_academica/'+data[0]);
                $('#modal_eliminar_modulo').modal('show');

            }  );
        });

    </script>

    <script type="text/javascript">
        var i = 0;
        $("#add").click(function () {
            if (i<10) {
                i++;
                $("#dynamicAdd").append(
                '<div id="fila' + i + '" class="dynamic-added" style="position: relative; margin-bottom: 2%">' +
                    '<select class="form-select form-select-lg lista_requisitos" name="requisito[' + i + ']" aria-label=".form-select-lg example" style= "font-size: 18; width: 90%" required>' +
                    '<option selected disabled="true" value="">Seleccionar un módulo</option>' +
                        '@foreach ($modulo as $m)' +
                            '<option value="{{$m['id']}}">{{$m['Nombre_modulo']}}</option>' +
                        '@endforeach' +
                    '</select>' +
                    '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" style="position: absolute; top: 0; margin: 0; right: 0">X</button>' +
                '</div>' 
                );
            }
        });
        $(document).on('click', '.btn_remove', function(){  

            var button_id = $(this).attr("id");   
            i--;
            $('#fila'+button_id+'').remove();  

        });

        $.ajaxSetup({

            headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

            }

        });

        $('#submit').click(function(){            

            $.ajax({  

                url:postURL,  

                method:"POST",  

                data:$('#crear_modulo').serialize(),

                type:'json',

                success:function(data)  

                {

                    if(data.error){

                        alert(data.error);

                    }else{

                        i=0;


                        $('.dynamic-added').remove();

                        $('#crear_modulo')[0].reset();

                    }

                }  

            });  

        });  

    </script>



</body>
@endsection

</html>
