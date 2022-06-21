@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar
        @foreach ($plan as $p)
            {{$p['Nombre']}}
        @endforeach
        -
        @foreach ($carrera as $c)
            {{$c['nombre']}} 
        @endforeach
    </title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

</head>
@section('content')
<body>
    <div class="container-fluid">

        <a href="/carreras/{{$c['id']}}"><img src="/images/back.png" alt="" srcset="" style="margin-top: 10px; margin-bottom: 10px"></a>
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <h1 class="mb-0 text-gray-800">
                    @foreach ($carrera as $c)
                    {{$c['nombre']}} 
                    @endforeach
                    -
                    @foreach ($plan as $p)
                    {{$p['Nombre']}}
                    @endforeach
                    <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="#modal_editar_plan" class="edit" > </button>
                
                </h1> 
        </div>

            <a href="/carreras/{{$c['id']}}/{{$p['id']}}/perfil_de_egreso"><button type="button" class="boton_gestionar">Perfil de Egreso</button></a> 

            <div class="form-inline" style="margin-top: 1%">
                <h5 style="color: black">Seleccionar total de semestres</h5>
                <select action="" class="form-select form-select-md" style="width: 10%; margin-left: 1%"name="" id="">
                    <option default selected value="1">1</option>
                    <option value="">2</option>
                </select>
            </div>

            <!--
            <div class="container-fluid kanban-container py-4 px-0">
                <div class="row d-flex flex-nowrap">
                    <div class="col-12 col-lg-6 col-xl-4 col-xxl-3">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h5 class="fs-6 fw-bold mb-0">
                                Semestre 1
                            </h5>

                            <div class="dropdown">
                                <button type="button" class="btn btn-sm fs-6 px-1 py-0 dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z">

                                        </path>
                                    </svg>
                                </button>
                                <div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1">
                                    <a class="dropdown-item d-flex align-items-center" href="#">
                                        <svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd">

                                            </path>
                                        </svg> 
                                        Eliminar
                                    </a>
                                </div>
                            </div>
                        </div>
                               <div id="kanbanColumn1" class="list-group kanban-list">
                                   <div class="card border-0 shadow p-4"><div class="card-header d-flex align-items-center justify-content-between border-0 p-0 mb-3"><h3 class="h5 mb-0">Cálculo 1</h3><div><div class="dropdown"><button type="button" class="btn btn-sm fs-6 px-1 py-0 dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg></button><div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1"><a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal"><svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg> Editar </a><div role="separator" class="dropdown-divider my-1"></div><a class="dropdown-item d-flex align-items-center" href="#"><svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> Eliminar</a></div>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-0" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item fw-normal rounded-top" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal"><span class="fas fa-edit"></span>Edit task</a> <a class="dropdown-item fw-normal" href="#"><span class="far fa-clone"></span>Copy Task</a> <a class="dropdown-item fw-normal" href="#"><span class="far fa-star"></span> Add to favorites</a><div role="separator" class="dropdown-divider my-0"></div><a class="dropdown-item fw-normal text-danger rounded-bottom" href="#"><span class="fas fa-trash-alt"></span>Remove</a></div></div></div></div>
                                        
                                    </div>

                                    <div class="card border-0 shadow p-4"><div class="card-header d-flex align-items-center justify-content-between border-0 p-0 mb-3"><h3 class="h5 mb-0">Introducción a la Programación</h3><div><div class="dropdown"><button type="button" class="btn btn-sm fs-6 px-1 py-0 dropdown-toggle" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false"><svg class="icon icon-xs text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z"></path><path fill-rule="evenodd" d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" clip-rule="evenodd"></path></svg></button><div class="dropdown-menu dashboard-dropdown dropdown-menu-start mt-2 py-1"><a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal"><svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"></path></svg> Editar </a><div role="separator" class="dropdown-divider my-1"></div><a class="dropdown-item d-flex align-items-center" href="#"><svg class="dropdown-icon text-danger me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg> Eliminar</a></div>
                                    <div class="dropdown-menu dashboard-dropdown dropdown-menu-start py-0" aria-labelledby="dropdownMenuLink">
                                        <a class="dropdown-item fw-normal rounded-top" href="#" data-bs-toggle="modal" data-bs-target="#editTaskModal"><span class="fas fa-edit"></span>Edit task</a> <a class="dropdown-item fw-normal" href="#"><span class="far fa-clone"></span>Copy Task</a> <a class="dropdown-item fw-normal" href="#"><span class="far fa-star"></span> Add to favorites</a><div role="separator" class="dropdown-divider my-0"></div><a class="dropdown-item fw-normal text-danger rounded-bottom" href="#"><span class="fas fa-trash-alt"></span>Remove</a></div></div></div></div>
                                        
                                    </div>                       
                                    <button class="agregar" href="#" style="font-size: 16; margin-top: 10px; margin-right: auto" data-bs-toggle="modal" data-bs-target="#modal_crear_modulo">
                                        Añadir módulo
                                    </button>
                                </div>     
                                
                                

                                
                    </div>

                </div>
            </div> -->
            

            <div class="container-fluid" style="margin-top: 1%">
                                        
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800" style="font-size: 32px">Semestre 1</h1>
                </div>

                <button class="agregar" href="#" style="font-size: 16; margin-top: 10px; margin-right: auto; margin-bottom: 2%" data-bs-toggle="modal" data-bs-target="#modal_crear_modulo">
                                            Añadir módulo
                    </button>

                <table id="lista" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th style="display: none">ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Prerrequisitos</th>
                            <th>Créditos</th>
                            <th>Horas semanales</th>
                            <th>Semestre</th>
                            <th>
                            </th>
                        </tr>

                    </thead>

                    <tbody>
                        <tr>
                            <td style="display: none"></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td>
                                <select class="form-select form-select-md"  aria-label=".form-select-md example" name="" id="">
                                    <option value="1">1</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" id="info" > </button>
                                <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="" class="edit"> </button>
                                <button type="button" id="del" data-bs-toggle="modal" data-bs-target="" class="delete"> </button>
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>

                    </tfoot>

                </table>

                    
            </div>

            <button class="agregar" style="font-size: 16; margin-top: 10px; margin-right: auto; margin-left: auto; display: block; margin-bottom: 2%">
                                            Añadir semestre
            </button>


       <div class="ms-auto ml-auto">
            <button class="btn btn-success">Guardar</button>
       </div>                                     


       <table>
           <thead>
                <tr>
                    
                </tr>
           </thead>
           <tbody>
               <tr>

               </tr>
           </tbody>
       </table>
                
    </div>


    <!--Modal modificar nombre plan de estudio -->
    <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1" class="modal fade" id="modal_editar_plan" aria-hidden="true"> 
                        <div class="modal-dialog modal-md">
                            <form action="/carreras/{{$c['id']}}/{{$p['id']}}" method="POST" class="form-group">
                            @csrf
                            @method('PUT')
                                <div class="modal-content" style="width: 600px">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Modificar Plan de Estudio</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nombre del plan</label>
                                                <input class="form-control form-control-lg" name="nombre_plan" style="width:100%"  placeholder="Ingrese el nombre del plan" value="{{$p['Nombre']}}" required/>  
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

    <!--Modal añadir modulo -->
    <div class="container">
            <div class="row">
                <div class ="col-md-12">
                    <div tabIndex="-1" class="modal fade" id="modal_crear_modulo" aria-hidden="true"> 
                        <div class="modal-dialog modal-md">
                            <form name ="add_modulo" id="add_modulo" action="" method="">
                            @csrf
                                <div class="modal-content" style="width: 600px">

                                    <div class="modal-header">
                                        <h1 class="justify-content-center" style="margin: auto"> Añadir Módulo</h1>
                                    </div>
                                    <div class="modal-body">

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Nombre del módulo</label>
                                                <input class="form-control form-control-lg" name="nombre_modulo" style="width:100%"  placeholder="Ingrese el nombre del módulo" />  
                                            </div>


                                            <div class="form-inline" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20; margin-right: 5px">Código</label>
                                                <input class="form-inline form-control form-control-lg" name="codigo_modulo" style="width: 120px; margin-right: 10px"  maxlength="4" placeholder="" />  
                                                <label style="font-size: 20; margin-right: 5px">Créditos</label>
                                                <input class="form-inline form-control form-control-lg" name="cred_modulo" type="number" style="width: 80px; margin-right: 10px" min="0" max="30" />   
                                                <label style="font-size: 20; margin-right: 5px">Horas semanales</label>
                                                <input class=" form-inline form-control form-control-lg" name="hrs_modulo" type="number" style="width: 80px; margin-right: 10px" min="0" max="99"/>                 
                                            </div>    

                                            <div class="form-group" style="margin: auto; margin-bottom: 20px">
                                                <label style="font-size: 20">Semestre</label>
                                                <select action="" class="form-select form-select-md" style="width: 20%; margin-left: 1%"name="" id="">
                                                    <option default selected value="1">1</option>
                                                    <option value="">2</option>
                                                </select>  
                                            </div>

                                            <hr class="sidebar-divider">
                                            
                                            <div class="form-group requisitos" id="requisitos" style="margin: auto; margin-bottom: 20px">
                                                <div class="form-inline">
                                                    <h5 style="font-size: 20; margin-right: 5px">Prerrequisitos</h5>  
                                                    
                                                    <button type="button" class="btn btn-info add" id="add" style="display: block; margin-left: 1%; font-weight: bold">
                                                        +
                                                    </button>

                                                </div>

                                            </div>   

                                            <hr class="sidebar-divider">

                                            <div class="form-group saberes" id ="saberes" style="margin: auto; margin-bottom: 20px">
                                                <div class="form-inline">
                                                    <h5 style="font-size: 20; margin-right: 5px; margin-bottom: 1%">Saberes</h5>  
                                                    <button type="button" class="btn btn-info add2" id ="add2" style="display: block; margin-left: 1%; font-weight: bold;">
                                                        +
                                                    </button>

                                                </div>


                                            </div>  

                                    </div>
                                    <div class="modal-footer">
                                                <button class="btn btn-success" type="submit" name="submit_req" id="submit_req">Guardar</button>
                                                <button class="btn btn-secondary" data-bs-dismiss="modal" type="button">Cancelar</button>
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


    <script type="text/javascript">
        $(document).ready(function(){      
        var i=0;  
        var j=0; 



        //añadir Pre requisitos
        $('#add').click(function(){  
            if (i < 5) {
                i++; 
                $('#requisitos').append(
                    '<div class="form-inline dynamic-added" id = "row'+i+'">' +
                    '<select class="form-select form-select-lg" aria-label=".form-select-lg example" name="requisito[]" style="width:80%; font-size: 18; margin-top: 2%">' +                                                  
                                                        '<option value="Calculo">Cálculo</option>'+
                                                        '<option value="Algebra">ALGEBRA</option>'+                                                                   
                                                    '</select>' +                    
                                                    '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove" style="font-weight: bold; margin-top: 1%; margin-left:  1%">X</button>'+ 
                    '</div>');
            }
                console.log(i);
        });  


        $(document).on('click', '.btn_remove', function(){  
            var button_id = $(this).attr("id");   
            $('#row'+button_id+'').remove();  
            i--;
            console.log(i);
        });  
            
        
        
            //añadir saberes
            $('#add2').click(function(){  
                if (j < 5) {
                    j++;  
                    $('#saberes').append(
                        '<div class="form-inline dynamic-added2" id = "row2'+j+'">' +
                        '<select class="form-select form-select-lg" aria-label=".form-select-lg example" name="saber[]" style="width:80%; font-size: 18; margin-top: 2%">' +                                                  
                                                            '@foreach ($saber as $s)' +
                                                                '<option value="{{$s["Descripcion_saber"]}}">{{$s["Descripcion_saber"]}}</option>' +
                                                            '@endforeach'+                                                            
                                                    '</select>' +                    
                                                        '<button type="button" name="remove2" id="'+j+'" class="btn btn-danger btn_remove2" style="font-weight: bold; margin-top: 1%; margin-left:  1%">X</button>'+ 
                        '</div>');
                }
                    console.log(j);
            });  


            $(document).on('click', '.btn_remove2', function(){  
                var button_id2 = $(this).attr("id");   
                $('#row2'+button_id2+'').remove();  
                j--; 
                console.log(j);
            }); 
            


         

        $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


        $('#submit_req').click(function(){            
            $.ajax({  
                    url:'/carreras/{{$c["id"]}}/{{$p["id"]}}/modulo',  
                    method:"POST",  
                    data:$('#add_modulo').serialize(),
                    type:'json',
                    success:function(data)  
                    {
                        if(data.error){
                            printErrorMsg(data.error);
                        }else{
                            i=1;
                            j=1;
                            //$('.dynamic-added').remove();
                            //$('.dynamic-added2').remove();
                            //$('#add_modulo')[0].reset();
                            //$(".print-success-msg").find("ul").html('');
                            //$(".print-success-msg").css('display','block');
                            //$(".print-error-msg").css('display','none');
                            //$(".print-success-msg").find("ul").append('<li>Record Inserted Successfully.</li>');
                        }
                    }  
            });  
        });  


        function printErrorMsg (msg) {
            $(".print-error-msg").find("ul").html('');
            $(".print-error-msg").css('display','block');
            $(".print-success-msg").css('display','none');
            $.each( msg, function( key, value ) {
                $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
            });
        }

    });
    </script>

</body>
@endsection
</html>