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
                
                <a href="/carreras"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
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
                <a href="/carreras/{{$c['id']}}/ver_aprendizajes"><button type="button" class="btn btn-secondary">Visualización de Aprendizajes</button></a> 
                <a href="/carreras/{{$c['id']}}/tempo_aprendizajes"><button type="button" class="btn btn-secondary">Temporalización de Aprendizajes</button></a> 

                <hr class="solid" style="border-width: 1px; background-color: black">

        </div>

        <div class="container-fluid" style="overflow-x:scroll; height: 92vh">   
            <h3 class="mb-0 text-gray-800">Gestión de Aprendizajes</h3>

            @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_aprendizaje" style="margin-bottom: 1%; margin-top: 1%">
                        Agregar aprendizaje                
                </button>
            @endif

            <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead style="text-align: center">
                                <tr style="font-weight: bold; color: white">
                                    <th rowspan="2" style="display: none">ID Competencia</th>
                                    <th rowspan="2" style="display: none">ID Dimension</th>
                                    <th rowspan="2" style="width: 20%; text-align: center">Competencia⇵</th>
                                    <th rowspan="2" style="width: 20%; text-align: center">Dimensión⇵</th>
                                    <th colspan="4" style="text-align: center">Aprendizajes</th>
                                </tr>
                                <tr style="font-weight: bold; color: white">
                                    <th style="display: none">ID Inicial</th>
                                    <th style="display: none">Inicial</th>
                                    <th style="width: 15%">Inicial⇵</th>
                                    <th style="display: none">Nivel inicial</th>
                                    <th style="display: none">ID Desarrollo</th>
                                    <th style="display: none">Desarrollo</th>
                                    <th style="width: 15%">En desarrollo⇵</th>
                                    <th style="display: none">Nivel desarrollo</th>
                                    <th style="display: none">ID Logrado</th>
                                    <th style="display: none">Logrado</th>
                                    <th style="width: 15%">Logrado⇵</th>
                                    <th style="display: none">Nivel logrado</th>
                                    <th style="display: none">ID Especializacion</th>
                                    <th style="display: none">Especializacion</th>
                                    <th style="width: 15%">Especialización⇵</th>
                                    <th style="display: none">Nivel especializacion</th>
                                </tr>
                        </thead>
                        
                        <tbody> 

                            @foreach ($aprendizaje as $aprend)
                                <tr>
                                    <td style="display: none">{{$aprend['idComp']}}</td>
                                    <td style="display: none">{{$aprend['idDim']}}</td>


                                    <td style="text-align: center">{{$aprend['OrdenComp']}}. {{$aprend['Descripcion']}}</td>
                                    <td style="text-align: center">{{$aprend['Orden']}}. {{$aprend['Descripcion_dimension']}}</td>

                                    <!--APRENDIZAJE INICIAL -->

                                    <td style="text-align: center;display: none ">         
                                        {{$aprend['id']}}                 
                                    </td>  
                                    <td style="display: none">{{$aprend['Descripcion_aprendizaje']}}</td>
                                    <td style="text-align: center">  
                                        @if ($aprend['Nivel_aprend'] == 'Inicial')
                                            @if (Auth::user()->rol != 'Dirección de docencia')
                                            <div class="dropdown-container" tabindex="-1" style="float:right;">
                                                <div class="three-dots"></div>
                                                <div class="dropdown dropdown-table">
                                                    <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_aprendizaje_inicial" class="edit1"> </button>
                                                    <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_aprendizaje" class="delete1"> </button>
                                                </div>
                                            </div>
                                            @endif       
                                        {{$aprend['Descripcion_aprendizaje']}}    
                                        @endif                     
                                    </td>
                                    <td style="display: none">{{$aprend['Nivel_aprend']}}</td>
                                

                                    <!--APRENDIZAJE EN DESARROLLO-->

                                    <td style="text-align: center;display: none">         
                                        {{$aprend['id']}}                 
                                    </td> 
                                    <td style="display: none">{{$aprend['Descripcion_aprendizaje']}}  </td>
                                    <td style="text-align: center">   
                                        @if ($aprend['Nivel_aprend'] == 'En desarrollo')
                                            @if (Auth::user()->rol != 'Dirección de docencia')
                                            <div class="dropdown-container" tabindex="-1" style="float:right;">
                                                <div class="three-dots"></div>
                                                <div class="dropdown dropdown-table">
                                                    <button type="button" id="info" data-bs-toggle="modal" data-bs-target="#modal_ver_datos" class="info"> </button>
                                                    <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_aprendizaje_desarrollo" class="edit2"> </button>
                                                    <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_aprendizaje" class="delete2"> </button>
                                                </div>
                                            </div>
                                            @endif    
                                            {{$aprend['Descripcion_aprendizaje']}}          
                                        @endif                          
                                    </td>
                                    <td style="display: none">{{$aprend['Nivel_aprend']}}</td>

                                    <!--APRENDIZAJE LOGRADO-->
                                    <td style="text-align: center;display: none">         
                                        {{$aprend['id']}}                 
                                    </td> 
                                    <td style="display: none">{{$aprend['Descripcion_aprendizaje']}}  </td>
                                    <td style="text-align: center"> 
                                        @if ($aprend['Nivel_aprend'] == 'Logrado')
                                            @if (Auth::user()->rol != 'Dirección de docencia')
                                            <div class="dropdown-container" tabindex="-1" style="float:right;">
                                                <div class="three-dots"></div>
                                                <div class="dropdown dropdown-table">
                                                    <button type="button" id="info" data-bs-toggle="modal" data-bs-target="#modal_ver_datos" class="info"> </button>
                                                    <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_aprendizaje_logrado" class="edit3"> </button>
                                                    <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_aprendizaje" class="delete3"> </button>
                                                </div>
                                            </div>
                                            @endif            
                                            {{$aprend['Descripcion_aprendizaje']}}      
                                        @endif                       
                                    </td>
                                    <td style="display: none">{{$aprend['Nivel_aprend']}}</td>

                                    <!--APRENDIZAJE ESPECIALIZACIÓN-->
                                    <td style="text-align: center;display: none">         
                                        {{$aprend['id']}}                 
                                    </td> 
                                    <td style="display: none">{{$aprend['Descripcion_aprendizaje']}}  </td>
                                    <td style="text-align: center">
                                        @if ($aprend['Nivel_aprend'] == 'Especialización')
                                            @if (Auth::user()->rol != 'Dirección de docencia')
                                                <div class="dropdown-container" tabindex="-1" style="float:right;">
                                                    <div class="three-dots"></div>
                                                    <div class="dropdown dropdown-table">
                                                        <button type="button" id="info" data-bs-toggle="modal" data-bs-target="#modal_ver_datos" class="info"> </button>
                                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_aprendizaje_especializacion" class="edit4"> </button>
                                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_aprendizaje" class="delete4"> </button>
                                                    </div>
                                                </div>
                                            @endif  
                                            {{$aprend['Descripcion_aprendizaje']}}  
                                        @endif
                                    </td>      
                                    <td style="display: none">{{$aprend['Nivel_aprend']}}</td>
                                </tr>
                            @endforeach   
                                                      
                        </tbody>
            </table> 


        </div>

        <!--MODALS APRENDIZAJE -->

        <!-- Modal crear aprendizaje -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_aprendizaje" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/aprendizajes" method="POST" class="form-group" id="createForm">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Descripción de Aprendizaje</label>
                                                <textarea class="form-control form-control-lg" name="aprendizaje_desc" type="text" style="color: black" placeholder="Ingrese la descripción del aprendizaje" rows="2" cols="50" maxlength="1000" required></textarea>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Nivel de Aprendizaje</label>
                                                <select class="form-select form-select-lg" name="nivel" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione el nivel de aprendizaje</option>                                     
                                                    <option value="Inicial">Inicial</option>           
                                                    <option value="En desarrollo">En desarrollo</option>   
                                                    <option value="Logrado">Logrado</option>   
                                                    <option value="Especialización">Especialización</option>                               
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; font-weight: bold">Competencia asociada</label>
                                                <select class="form-select form-select-lg" name="refCompCrear" id="refCompCrear" onchange="addDimension()" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                    <option selected disabled="true" value="">Seleccione la competencia asociada</option>          
                                                    @foreach ($competencia as $comp)                           
                                                        <option value="{{$comp['id']}}">{{$comp['Descripcion']}}</option>     
                                                    @endforeach                                                                                  
                                                </select>
                                            </div>



                                            <div id="dimension-crear"></div>
                                          
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

        <!-- Modal modificar aprendizaje inicial   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_aprendizaje_inicial" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "editFormInicial">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                            <label style="font-size: 20; font-weight: bold">Descripción de Aprendizaje</label>
                                            <textarea class="form-control form-control-lg" id="aprendizaje_inicial" name="aprendizaje_inicial" type="text" style="color: black" placeholder="Ingrese la descripción del aprendizaje" rows="2" cols="50" maxlength="200" required></textarea>
                                        </div>

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                            <label style="font-size: 20; font-weight: bold">Nivel de Aprendizaje</label>
                                            <select class="form-select form-select-lg" name="nivel_inicial" id="nivel_inicial" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                <option selected disabled="true" value="">Seleccione el nivel de aprendizaje</option>                                     
                                                <option value="Inicial">Inicial</option>           
                                                <option value="En desarrollo">En desarrollo</option>   
                                                <option value="Logrado">Logrado</option>   
                                                <option value="Especialización">Especialización</option>                               
                                            </select>
                                        </div>

                                        <input type="text" style="display:none" value="Inicial" name="Nivel">

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

        <!-- Modal modificar aprendizaje desarrollo   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_aprendizaje_desarrollo" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "editFormDesarrollo">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                            <label style="font-size: 20; font-weight: bold">Descripción de Aprendizaje</label>
                                            <textarea class="form-control form-control-lg" id="aprendizaje_desarrollo" name="aprendizaje_desarrollo" type="text" style="color: black" placeholder="Ingrese la descripción del aprendizaje" rows="2" cols="50" maxlength="200" required></textarea>
                                        </div>

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                            <label style="font-size: 20; font-weight: bold">Nivel de Aprendizaje</label>
                                            <select class="form-select form-select-lg" name="nivel_desarrollo" id="nivel_desarrollo" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                <option selected disabled="true" value="">Seleccione el nivel de aprendizaje</option>                                     
                                                <option value="Inicial">Inicial</option>           
                                                <option value="En desarrollo">En desarrollo</option>   
                                                <option value="Logrado">Logrado</option>   
                                                <option value="Especialización">Especialización</option>                               
                                            </select>
                                        </div>

                                        <input type="text" style="display:none" value="En desarrollo" name="Nivel">


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

        <!-- Modal modificar aprendizaje logrado   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_aprendizaje_logrado" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "editFormLogrado">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                            <label style="font-size: 20; font-weight: bold">Descripción de Aprendizaje</label>
                                            <textarea class="form-control form-control-lg" id="aprendizaje_logrado" name="aprendizaje_logrado" type="text" style="color: black" placeholder="Ingrese la descripción del aprendizaje" rows="2" cols="50" maxlength="200" required></textarea>
                                        </div>

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                            <label style="font-size: 20; font-weight: bold">Nivel de Aprendizaje</label>
                                            <select class="form-select form-select-lg" name="nivel_logrado" id="nivel_logrado" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                <option selected disabled="true" value="">Seleccione el nivel de aprendizaje</option>                                     
                                                <option value="Inicial">Inicial</option>           
                                                <option value="En desarrollo">En desarrollo</option>   
                                                <option value="Logrado">Logrado</option>   
                                                <option value="Especialización">Especialización</option>                               
                                            </select>
                                        </div>

                                        <input type="text" style="display:none" value="Logrado" name="Nivel">

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

        <!-- Modal modificar aprendizaje especializacion   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_aprendizaje_especializacion" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "editFormEspecializacion">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                            <label style="font-size: 20; font-weight: bold">Descripción de Aprendizaje</label>
                                            <textarea class="form-control form-control-lg" id="aprendizaje_especializacion" name="aprendizaje_especializacion" type="text" style="color: black" placeholder="Ingrese la descripción del aprendizaje" rows="2" cols="50" maxlength="200" required></textarea>
                                        </div>

                                        <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                            <label style="font-size: 20; font-weight: bold">Nivel de Aprendizaje</label>
                                            <select class="form-select form-select-lg" name="nivel_especializacion" id="nivel_especializacion" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required>
                                                <option selected disabled="true" value="">Seleccione el nivel de aprendizaje</option>                                     
                                                <option value="Inicial">Inicial</option>           
                                                <option value="En desarrollo">En desarrollo</option>   
                                                <option value="Logrado">Logrado</option>   
                                                <option value="Especialización">Especialización</option>                               
                                            </select>
                                        </div>

                                        <input type="text" style="display:none" value="Especialización" name="Nivel">


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




        <!-- Modal eliminar aprendizaje inicial   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_aprendizaje_inicial" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "deleteFormInicial">

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

        <!-- Modal eliminar aprendizaje desarrollo   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_aprendizaje_desarrollo" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "deleteFormDesarrollo">

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

        <!-- Modal eliminar aprendizaje logrado   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_aprendizaje_logrado" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "deleteFormLogrado">

                                {{ csrf_field() }}
                                {{ method_field('DELETE')}}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar éste aprendizaje? Se eliminarán todos los saberes y módulos vinculados.</p>
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

        <!-- Modal eliminar aprendizaje especializacion   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_aprendizaje_especializacion" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "post" action = "/carreras/{{$c['id']}}/aprendizajes" class="form-group" id = "deleteFormEspecializacion">

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


            //TABLA DE APRENDIZAJES

            //ver datos
            table.on('click', '.info', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);




                document.getElementById("#created_at").innerHTML ='<h6>' + 'xd' + '</h6>';
                document.getElementById("#updated_at").innerHTML = '<h6>' + 'xd' + '</h6>';

                $('#modal_ver_datos').modal('show');

            });

            //modificar inicial
            table.on('click', '.edit1', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#aprendizaje_inicial').val(data[5]);
                $('#nivel_inicial').val(data[7]);


                $('#editFormInicial').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[4]);
                $('#modal_modificar_aprendizaje_inicial').modal('show');

            });

            //modificar en desarrollo
            table.on('click', '.edit2', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#aprendizaje_desarrollo').val(data[9]);
                $('#nivel_desarrollo').val(data[11]);

                $('#editFormDesarrollo').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[8]);
                $('#modal_modificar_aprendizaje_desarrollo').modal('show');

            });

            //modificar logrado
            table.on('click', '.edit3', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#aprendizaje_logrado').val(data[13]);
                $('#nivel_logrado').val(data[15]);

                $('#editFormLogrado').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[12]);
                $('#modal_modificar_aprendizaje_logrado').modal('show');

            });

            //modificar especializacion
            table.on('click', '.edit4', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#aprendizaje_especializacion').val(data[17]);
                $('#nivel_logrado').val(data[19]);

                $('#editFormEspecializacion').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[16]);
                $('#modal_modificar_aprendizaje_especializacion').modal('show');

            });


            //eliminar inicial
            table.on('click', '.delete1', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteFormInicial').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[4]);
                $('#modal_eliminar_aprendizaje_inicial').modal('show');

            }  );

            //eliminar desarrollo
            table.on('click', '.delete2', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteFormDesarrollo').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[8]);
                $('#modal_eliminar_aprendizaje_desarrollo').modal('show');

            }  );

            //eliminar logrado
            table.on('click', '.delete3', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteFormLogrado').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[12]);
                $('#modal_eliminar_aprendizaje_logrado').modal('show');

            }  );

            //eliminar especializacion
            table.on('click', '.delete4', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteFormEspecializacion').attr('action', '/carreras/{{$c['id']}}/aprendizajes/'+data[16]);
                $('#modal_eliminar_aprendizaje_especializacion').modal('show');

            }  );


            

        });

    </script>

    <script>

        function addDimension() {

                var x = document.getElementById("refCompCrear").value;
                $.ajax({
                    type: "GET",
                    url: '/carreras/{{$c['id']}}/aprendizajes/' + x, 
                    data: { id: x },
                }).done(function(response) {
                    //string del codigo html que se inyectará en el div
                    var lista = '<div class="form-group" style="margin: auto">' +
                            '<label style="font-size: 20; font-weight: bold">Dimension asociada</label>'+
                            '<select class="form-select form-select-lg" name="dimension" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 2%; font-size: 18" required> '+
                                '<option selected disabled="true" value="">Seleccione una dimensión</option>';          
                    
                    //si la respuesta tiene a lo menos un objeto, se recorre el array añadiendo cada dimensión como una opción
                    if (response.length > 0) {
                        for (const prop in response) {         
                                lista +=    '<option value="' + response[prop]['id'] + '">' + response[prop]['Descripcion_dimension'] + '</option>';        
                        } 
                    }       
                    
                    lista += '</select>'+
                        '</div>';                 
                    
                    document.getElementById("dimension-crear").innerHTML = lista;
                });                  
        }

    </script>
</body>
@endsection

</html>
