@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Lista de Usuarios</title>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
        <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
</head>
@section('content')
<body >
        <div class="container-fluid">   
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800">Lista de Usuarios</h1>
                </div>

                <button class="agregar" href="#" data-bs-toggle="modal" data-bs-target="#modal_user" style="font-size: 16; margin-bottom: 10px;">
                Agregar usuario
                </button>

                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Nombre de usuario <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Correo Electrónico <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th style="width: 150px"></th>
                                </tr>
                        </thead>
                        
                        <tbody>
                        
                                @foreach($user as $u)
                                <tr>
                                <td style="display: none"> {{$u['id']}}</td>
                                <td> {{$u['nombre']}}</td>
                                <td>{{$u['email']}}</td>
                                <td>
                                        <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_modificar_carrera" class="edit"> </button>
                                        <button type="button" id="del" data-bs-toggle="modal" data-bs-target="#modal_eliminar_carrera" class="delete"> </button>
                                </td>
                                
                                </tr>
                                @endforeach
                        
                        </tbody>
                </table> 

        </div>



        <!-- Modal agregar usuario-->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1" class="modal fade" id="modal_user" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form action="/usuarios" method="POST" class="form-group">
                                @csrf
                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Agregar usuario</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group" style="margin: auto;">
                                            <label style="font-size: 20">Nombre Completo</label>
                                            <input type="name" class="form-control form-control-lg" name="nombre"  style="width:100%; margin-bottom: 20px" placeholder="Ingrese el nombre del usuario" maxlength="100" required />
                                        </div>

                                        <div class="form-group" style="margin: auto;">
                                            <label style="font-size: 20" >Correo Electrónico</label>
                                            <input type="email" class="form-control form-control-lg" name="email" style="width:100%; margin-bottom: 20px" placeholder="Ingrese el correo del usuario" maxlength="100" required />
                                        </div>



                                        <div class="form-inline" id="show_hide_password">
                                            <label style="font-size: 20">Contraseña</label>
                                            <input type="password" class="form-control form-control-lg" name="password" id="password" style="width:92%; margin-bottom: 20px" autocomplete="new-password" placeholder="Ingrese la contraseña del usuario" maxlength="20" required/>
                                            <div class="form-group-addon" style="padding-left: 1%; margin-bottom: 2%">
                                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-inline" id="show_hide_password2">
                                            <label style="font-size: 20">Confirmar contraseña</label>
                                            <input type="password" class="form-control form-control-lg" name="password_confirmation" id = "password_confirmation" style="width:92%; margin-bottom: 20px" autocomplete="new-password" placeholder="Ingrese nuevamente la contraseña del usuario" maxlength="20" required/>
                                            <div class="form-group-addon" style="padding-left: 1%; margin-bottom: 2%">
                                                    <a href=""><i class="fa fa-eye-slash" aria-hidden="true"></i></a>
                                            </div>
                                        </div>

                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button class="btn btn-success" type="submit">Guardar</button>
                                        <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
                                    </div> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       </div>


        <!-- Modal modificar usuario   -->

        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_modificar_usuario" aria-hidden="true">
                        <div class="modal-dialog modal-md" >

                            <form method = "post" action = "/usuarios" class="form-group" id = "editForm">

                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar Usuario</h1>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group" style="margin: auto;">
                                            <label style="font-size: 20">Nombre Completo</label>
                                            <input type="name" class="form-control form-control-lg" name="nombre" id="nombre" style="width:95%; margin-bottom: 20px" placeholder="Ingrese el nombre del usuario" maxlength="100" required />
                                        </div>

                                        <div class="form-group" style="margin: auto;">
                                            <label style="font-size: 20" >Correo Electrónico</label>
                                            <input type="email" class="form-control form-control-lg" name="email" id="email" style="width:95%; margin-bottom: 20px" placeholder="Ingrese el correo del usuario" maxlength="100" required/>
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




        <!-- Modal eliminar usuario   -->
        <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div class="modal fade" id="modal_eliminar_usuario" aria-hidden="true">
                        <div class="modal-dialog modal-md" >
                            <form method = "post" action = "/usuarios" class="form-group" id = "deleteForm">

                                {{ csrf_field() }}
                                {{ method_field('DELETE')}}

                                <div class="modal-content">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Eliminar Usuario</h1>
                                    </div>
                                    <div class="modal-body">
                                        <input type="hidden" name="method" value="DELETE"> 
                                        <p style="font-size: 18">¿Está seguro de que desea eliminar a éste usuario?</p>
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

            

            //modificar
            table.on('click', '.edit', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }


                var data = table.row($tr).data();
                console.log(data);

                $('#nombre').val(data[1]);
                $('#email').val(data[2]);

                $('#editForm').attr('action', '/usuarios/'+data[0]);
                $('#modal_modificar_usuario').modal('show');

            });


            //eliminar
            table.on('click', '.delete', function() {

                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);


                $('#deleteForm').attr('action', '/usuarios/'+data[0]);
                $('#modal_eliminar_usuario').modal('show');

            }  );
            
        });

    </script>

    
</body>
@endsection

</html>
