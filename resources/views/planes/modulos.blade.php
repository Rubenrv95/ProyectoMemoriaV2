@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Propuesta de Módulo
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
                    Malla Curricular                    
                    @foreach ($plan as $p)
                    {{$p['Nombre']}}
                    @endforeach
                    -
                    @foreach ($carrera as $c)
                    {{$c['nombre']}} 
                    @endforeach
                
                </h1> 
        </div>

        <hr class="solid">

            <a href="/carreras/{{$c['id']}}/{{$p['id']}}/competencias"><button type="button" class="boton_gestionar">Competencias</button></a> 
            <a href="/carreras/{{$c['id']}}/{{$p['id']}}/aprendizajes"><button type="button" class="boton_gestionar">Aprendizajes</button></a> 
            <a href="/carreras/{{$c['id']}}/{{$p['id']}}/saberes"><button type="button" class="boton_gestionar">Saberes</button></a> 
            <a href="/carreras/{{$c['id']}}/{{$p['id']}}/malla"><button type="button" class="boton_gestionar">Módulos</button></a> 

        <hr class="solid">
    
            

                
    </div>

    <div class="container-fluid">
        
        <h3 class="mb-0 text-gray-800">Módulos</h3>
                                        
        @if (Auth::user()->rol != 'Dirección de docencia')
                <button class="agregar" href="#" style="font-size: 16; margin-right: auto; margin-bottom: 1%; margin-top: 1%" data-bs-toggle="modal" data-bs-target="#modal_crear_modulo">
                        Agregar módulo
                </button>
        @endif

                <table id="lista" class="table table-striped table-bordered" width="100%">
                    <thead>
                        <tr>
                            <th style="display: none">ID</th>
                            <th>Nivel</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Prerrequisitos</th>
                            <th>Créditos</th>
                            <th>Horas semanales</th>
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
                            <td></td>
                            <td>
                                <button type="button" id="info" > </button>
                                @if (Auth::user()->rol != 'Dirección de docencia')
                                <button type="button" id="mod" data-bs-toggle="modal" data-bs-target="" class="edit"> </button>
                                <button type="button" id="del" data-bs-toggle="modal" data-bs-target="" class="delete"> </button>
                                @endif
                            </td>
                        </tr>
                    </tbody>

                    <tfoot>

                    </tfoot>

                </table>

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
                                                            '@foreach ($saber_conocer as $s)' +
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