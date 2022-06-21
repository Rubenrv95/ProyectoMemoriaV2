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
                
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Perfil de Egreso {{$p['Nombre']}} - {{$c['nombre']}} </h1>
                </div>

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800" style="font-size: 32px">Competencias </h1>
                </div>

                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_competencia" style="margin-bottom: 10px;">
                        Agregar competencia                   
                </button>

                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID <img src="/images/arrows.png" alt="" srcset=""> </th>
                                <th>Descripción<img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Tipo de Competencia <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Nivel de Desarrollo <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th style="width: 150px"></th>
                                </tr>
                        </thead>
                        
                        <tbody>
                        
                            @foreach ($competencia as $comp)   
                                <tr>
                                <td style="display: none">{{$comp['id']}}</td>
                                <td>{{$comp['Descripcion']}}</td>
                                <td>{{$comp['Tipo']}}</td>
                                <td>{{$comp['Nivel']}}</td>
                                <td>
                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_competencia" class="edit"> </button>
                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_competencia" class="delete"> </button>
                                </td>
                                
                                </tr>
                            @endforeach   
                        
                        </tbody>
                </table> 

                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800" style="font-size: 32px">Aprendizajes</h1>
                </div>

                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_aprendizaje" style="margin-bottom: 10px;">
                        Agregar aprendizaje                    
                </button>

                <table id="lista2" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID <img src="/images/arrows.png" alt="" srcset=""> </th>
                                <th>Descripción <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Tipo de Aprendizaje<img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Competencia Asociada <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th style="width: 150px"></th>
                                </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($aprendizaje as $a)   
                                <tr>
                                <td style="display: none">{{$a['id']}}</td>
                                <td>{{$a['Descripcion_aprendizaje']}}</td>
                                <td>{{$a['tipo_aprendizaje']}}</td>
                                <td>{{$a['Descripcion']}}</td>
                                <td>
                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_aprendizaje" class="edit2"> </button>
                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_aprendizaje" class="delete2"> </button>
                                </td>
                                
                                </tr>
                            @endforeach   

                        </tbody>
                </table> 


                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800" style="font-size: 32px">Saberes</h1>
                </div>

                <button class="agregar" data-bs-toggle="modal" data-bs-target="#modal_crear_saber" style="margin-bottom: 10px;">
                        Agregar saber                   
                </button>

                <table id="lista3" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID <img src="/images/arrows.png" alt="" srcset=""> </th>
                                <th>Descripción <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Tipo <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Aprendizaje Asociado <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th style="width: 150px"></th>
                                </tr>
                        </thead>
                        
                        <tbody> 
                            @foreach ($saber as $s) 
                                <tr>
                                <td style="display: none">{{$s['id']}}</td>
                                <td>{{$s['Descripcion_saber']}}</td>
                                <td>{{$s['tipo_saber']}}</td>
                                <td>{{$s['Descripcion_aprendizaje']}}</td>
                                <td>
                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_saber" class="edit3"> </button>
                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_saber" class="delete3"> </button>
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
                            <form action="/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar competencia</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción de la competencia</label>
                                                <textarea class="form-control" name="desc_competencia" type="text"  placeholder="Ingrese la descripción de la competencia" rows="3" cols="50" maxlength="200" required></textarea>
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar una descripción para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Tipo de Competencia</label>
                                                <select class="form-select form-select-lg" name="tipo" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    <option selected value="Disciplinaria">Disciplinaria</option>
                                                    <option value="Formación fundamental">Formación fundamental</option>
                                                    <option value="Idiomas">Idiomas</option>
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Nivel de Desarrollo</label>
                                                <select class="form-select form-select-lg" name="nivel" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    <option selected value="Básico">Básico</option>
                                                    <option value="Medio">Medio</option>
                                                    <option value="Avanzado">Avanzado</option>
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


        <!-- Modal modificar competencia   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_competencia" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "POST" action = "/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso" class="form-group" id = "editForm">

                            @csrf
                            @method('PUT')

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar competencia</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción de la competencia</label>
                                                <textarea class="form-control" name="desc_competencia" id="desc_competencia" type="text"  placeholder="Ingrese la descripción de la competencia" rows="3" cols="50" maxlength="200" required></textarea>
                                                <span style="color: red">@error('desc_competencia')  Debe ingresar una descripción para la competencia  @enderror</span>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Tipo de Competencia</label>
                                                <select class="form-select form-select-lg" name="tipo" id="tipo" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    <option selected value="Disciplinaria">Disciplinaria</option>
                                                    <option value="Formación fundamental">Formación fundamental</option>
                                                    <option value="Idiomas">Idiomas</option>
                                                </select>
                                            </div>
                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Nivel de Desarrollo</label>
                                                <select class="form-select form-select-lg" name="nivel" id="nivel" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    <option selected value="Básico">Básico</option>
                                                    <option value="Medio">Medio</option>
                                                    <option value="Avanzado">Avanzado</option>
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




        <!-- Modal eliminar competencia   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_competencia" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "POST" action = "/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso" class="form-group" id = "deleteForm">

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


        <!--Terminan Modals Competencia -->

        <!--MODALS APRENDIZAJE -->

        <!-- Modal crear aprendizaje   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1"  class="modal fade" id="modal_crear_aprendizaje" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso/aprendizajes" method="POST" class="form-group">
                            @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción del aprendizaje</label>
                                                <textarea class="form-control" name="desc_aprendizaje" type="text"  placeholder="Ingrese la descripción del aprendizaje" rows="3" cols="50" maxlength="200" required></textarea>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Tipo de aprendizaje</label>
                                                <select class="form-select form-select-lg" name="tipo_aprend" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>   
                                                    <option selected value="Inicial">Inicial</option>
                                                    <option value="En desarrollo">En desarrollo</option>
                                                    <option value="Logrado">Logrado</option>
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Competencia asociada</label>
                                                <select class="form-select form-select-lg" name="refComp" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required> 
                                                    @foreach ($competencia as $comp) 
                                                    <option value="{{$comp['id']}}">{{$comp['Descripcion']}}</option>
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


        <!-- Modal modificar aprendizaje   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_aprendizaje" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "post" action = "" class="form-group" id = "editForm2">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar aprendizaje</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Descripción del aprendizaje </label>
                                                <textarea class="form-control" name="desc_aprendizaje" id="desc_aprendizaje" type="text"  placeholder="Ingrese la descripción del aprendizaje" rows="3" cols="50" maxlength="200" required></textarea>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Tipo de aprendizaje</label>
                                                <select class="form-select form-select-lg" name="tipo_aprend" id ="tipo_aprend" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>   
                                                    <option selected value="Inicial">Inicial</option>
                                                    <option value="En desarrollo">En desarrollo</option>
                                                    <option value="Logrado">Logrado</option>
                                                </select>
                                            </div>

                                            <div class="form-group" style="margin: auto">
                                                <label style="font-size: 20">Competencia asociada</label>
                                                <select class="form-select form-select-lg" name="refComp" id="refComp" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" placeholder="Seleccione una competencia" required>
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
                            <form method = "post" action = "" class="form-group" id = "deleteForm2">

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

        <!--Terminan modals aprendizajes -->

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
                                                <label style="font-size: 20">Tipo de Saber</label>
                                                <select class="form-select form-select-lg" name="tipo_saber" aria-label=".form-select-lg example" style="width:100%; margin-bottom: 20px; font-size: 18" required>
                                                    <option selected value="Cognitivo">Cognitivo</option>
                                                    <option value="Actitudinal">Actitudinal</option>
                                                    <option value="Procedimental">Procedimental</option>
                                                </select>
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

            var table2 = $('#lista2').DataTable({

                "sDom": '<"top"f>        rt      <"bottom"ip>      <"clear">',
                "order": [[ 1, "asc" ]]
            });

            var table3 = $('#lista3').DataTable({

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


            //TABLA DE APRENDIZAJES
            

            //modificar
            table2.on('click', '.edit2', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table2.row($tr).data();
                console.log(data);

                $('#desc_aprendizaje').val(data[1]);
                $('#tipo_aprend').val(data[2]);
                //$('#refComp').val(data[3]);

                $('#editForm2').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso/aprendizajes/'+data[0]);
                $('#modal_modificar_aprendizaje').modal('show');

            });


            //eliminar
            table2.on('click', '.delete2', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table2.row($tr).data();
                console.log(data);


                $('#deleteForm2').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso/aprendizajes/'+data[0]);
                $('#modal_eliminar_aprendizaje').modal('show');

            }  );

            //TABLA DE SABERES
            

            //modificar
            table3.on('click', '.edit3', function() {

            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }


            var data = table3.row($tr).data();
            console.log(data);

            $('#desc_saber').val(data[1]);
            $('#tipo_saber').val(data[2]);
            //$('#refAprend').val(data[3]);

            $('#editForm3').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso/saberes/'+data[0]);
            $('#modal_modificar_saber').modal('show');

            });


            //eliminar
            table3.on('click', '.delete3', function() {

            $tr = $(this).closest('tr');
            if ($($tr).hasClass('child')) {
                $tr = $tr.prev('.parent');
            }

            var data = table3.row($tr).data();
            console.log(data);


            $('#deleteForm3').attr('action', '/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso/saberes/'+data[0]);
            $('#modal_eliminar_saber').modal('show');

            }  );
        });

    </script>
</body>
@endsection

</html>
