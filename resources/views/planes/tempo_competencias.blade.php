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
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saber_conocer"><button type="button" class="boton_gestionar">Saberes</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/malla"><button type="button" class="boton_gestionar">Módulos</button></a> 

                <hr class="solid">

                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="btn btn-secondary">Gestión de Competencias</button></a> 
                <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="btn btn-secondary">Temporalización de Competencias</button></a> 

                <hr class="solid">

        </div>
        <div class="container-fluid">   
            <h3 class="mb-0 text-gray-800">Temporalización de Competencias</h3>


            <form action="" method="post">
                <table id="lista" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <th>Competencia</th>
                        <th>Nivel 1</th>
                        <th>Nivel 2</th>
                        <th>Nivel 3</th>
                        <th>Nivel 4</th>
                        <th>Nivel 5</th>
                        <th>Nivel 6</th>
                        <th>Nivel 7</th>
                        <th>Nivel 8</th>
                        <th>Nivel 9</th>
                        <th>Nivel 10</th>
                        <th>Nivel 11</th>
                        <th>Nivel 12</th>
                    </thead>
                    <tbody>
                        @foreach ($competencia as $c)
                        <tr>
                            <td>{{$c['Nombre']}}</td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
                            <td> <input type="checkbox"></td>
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

            
        });

    </script>
</body>
@endsection

</html>
