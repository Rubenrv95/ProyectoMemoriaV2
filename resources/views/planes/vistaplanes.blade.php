@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Planes de Estudio</title>
</head>
@section('content')
<body>
    <div class="container-fluid">   
                
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="mb-0 text-gray-800" style="font-size: 32px">Lista de Planes de Estudio</h1>
                </div>


                <table id="lista" class="table table-striped table-bordered" width="100%">
                        <thead>
                                <tr style="font-weight: bold; color: white">
                                <th style="display: none">ID <img src="/images/arrows.png" alt="" srcset=""> </th>
                                <th>Nombre del Plan<img src="/images/arrows.png" alt="" srcset=""></th>
                                <th>Carrera asociada <img src="/images/arrows.png" alt="" srcset=""></th>
                                <th style="width: 150px"></th>
                                </tr>
                        </thead>
                        
                        <tbody>
                        
                            @foreach ($data as $p)
                                <tr>
                                <td style="display: none">{{$p['id']}}</td>
                                <td>{{$p['Nombre']}}</td>
                                <td>{{$p['Ncarrera']}}</td>
                                <td>
                                    <a href="/carreras/{{$p['idCarrera']}}/{{$p['id']}}"><button type="button" id="info" > </button></a>
                                </td>
                                
                                </tr>
                            @endforeach   
                        
                        </tbody>
                </table> 
    </div>


    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script>    
        $(document).ready(function() {
            var table = $('#lista').DataTable( {
                "sDom": '<"top"f>        rt      <"bottom"ip>      <"clear">',
                "order": [[ 2, "asc" ]]
                
            });           
        });

    </script>
</body>
@endsection
</html>