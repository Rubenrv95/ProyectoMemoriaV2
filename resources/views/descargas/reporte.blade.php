<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporte de Plan de Estudio</title>
</head>
<body>
    
    <h3 style="text-align: center">UniverXdad de Talca</h3>
    @foreach ($carrera_seleccionada as $car)
    <h1 style="text-align: center">Resumen Plan de Estudio {{$car['nombre']}}</h1>
    @endforeach

    <p>A continuación, se presenta un reporte de toda la información de la carrera de {{$car['nombre']}}, incluyendo
        competencias, aprendizajes, saberes y módulos asociados.
    </p>

    <h2>Competencias</h2>

    <table border="1" style='border-collapse: collapse; text-align: center;' >
        <thead>
            <tr>
                <td>Orden</td>
                <td>Descripción de Competencia</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($competencia as $c)
            <tr>
                <td>{{$c['Orden']}}</td>
                <td>{{$c['Descripcion']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always"></div>

    <h2>Temporalización de Competencias</h2>

    <table border="1" style='border-collapse: collapse; text-align: center;' >
        <thead>
            <tr>
                <td>Descripción de Competencia</td>
                @for ($i = 1; $i <= 14; $i++)
                    <td>Nivel {{$i}}</td>
                @endfor
            </tr>
        </thead>
        <tbody>
        @foreach ($tempo_competencia as $tc)
            <tr>
                <td>{{$tc['Orden']}}. {{$tc['Descripcion']}}</td>
                @for ($i = 1; $i <= 14; $i++)
                    <td  style="text-align: center"> 
                        @if ($tc[$i]== 1) 
                            X
                        @else

                        @endif
                    </td>
                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always"></div>

    <h2>Aprendizajes</h2>

    <table border="1" style='border-collapse: collapse; text-align: center;'>
        <thead>
            <tr>
                <td>Competencia asociada</td>
                <td>Dimensión</td>
                <td>Aprendizaje</td>
                <td>Nivel de aprendizaje</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($aprendizaje as $a)
            <tr>
                <td rowspan="1">{{$a['OrdenComp']}}. {{$a['Descripcion']}}</td>
                <td rowspan="1">{{$a['Descripcion_dimension']}}</td>
                <td rowspan="1">{{$a['Descripcion_aprendizaje']}}</td>
                <td rowspan="1">{{$a['Nivel_aprend']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always"></div>

    <h2>Temporalización de Aprendizajes</h2>

    <table border="1" style='border-collapse: collapse; text-align: center;' >
        <thead>
            <tr>
                <td>Competencia</td>
                <td>Nivel de Aprendizaje</td>
                <td>Aprendizaje</td>
                <td>Dimensión</td>
                @for ($i = 1; $i <= 14; $i++)
                    <td>{{$i}}</td>
                @endfor
            </tr>
        </thead>
        <tbody>
        @foreach ($tempo_aprendizaje as $ta)
            <tr>
                <td >{{$ta['OrdenComp']}}. {{$ta['Descripcion']}}</td>
                <td >{{$ta['Nivel_aprend']}}</td>
                <td>{{$ta['Descripcion_aprendizaje']}}</td>
                <td>{{$ta['Orden']}}. {{$ta['Descripcion_dimension']}}</td>
                @for ($i = 1; $i <= 14; $i++)
                    <td  style="text-align: center"> 
                        @if ($ta[$i]== 1) 
                            X
                        @else

                        @endif
                    </td>
                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>


    <div style="page-break-after: always"></div>

    <h2>Saberes</h2>

    <table border="1" style='border-collapse: collapse; text-align: center;'>
        <thead>
            <tr>
                <td>Competencia asociada</td>
                <td>Dimensión</td>
                <td>Aprendizaje</td>
                <td>Saber</td>
                <td>Tipo de Saber</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($saber as $s)
            <tr>
                <td rowspan="1">{{$s['OrdenComp']}}. {{$s['Descripcion']}}</td>
                <td rowspan="1">{{$s['Descripcion_dimension']}}</td>
                <td rowspan="1">{{$s['Descripcion_aprendizaje']}}</td>
                <td rowspan="1">{{$s['Descripcion_saber']}}</td>
                <td rowspan="1">{{$s['Tipo']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always"></div>

    <h2>Carga Académica</h2>

    <table border="1" style='border-collapse: collapse; text-align: center;'>
        <thead style="text-align: center">

            <tr>
                <th rowspan="2"style="text-align: center">Semestre</th>
                <th rowspan="2"style="text-align: center">Módulo</th>
                <th rowspan="2"style="text-align: center">Tipo Curso</th>
                <th rowspan="2"style="text-align: center;">Clases</th>
                <th rowspan="2"style="text-align: center;">SEM</th>
                <th rowspan="2" style="text-align: center;">AYU</th>
                <th colspan="3">Act. Prácticas, de Laboratorio</th>
                <th colspan="2">Act. Clínicas o terreno</th>
                <th colspan="2">Trabajo Autónomo</th>
                <th rowspan="2" style="text-align: center;">Horas semanales</th>
                <th rowspan="2" style="text-align: center;">Total horas del módulo</th>
                <th rowspan="2" style="text-align: center;">SCT-Chile</th>
                
            </tr>

            <tr>
                <th style="text-align: center;">AP</th>
                <th style="text-align: center;">LAB</th>
                <th style="text-align: center;">TALL</th>
                <th style="text-align: center;">AC</th>
                <th style="text-align: center;">TE</th>
                <th style="text-align: center;">Tareas</th>
                <th style="text-align: center;">Estudio</th>
            </tr>

        </thead>

            <tbody> 

            @foreach ($modulo as $m)
            <tr>                                 
                <td style="text-align: center">{{$m['Semestre']}}</td>
                <td style="text-align: center">{{$m['Nombre_modulo']}}</td>
                <td style="text-align: center">{{$m['Tipo']}}</td>
                <td style="text-align: center">
                    @if ($m['Clases'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>

                <td style="text-align: center">
                    @if ($m['Seminario'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['Ayudantias'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['Actividades_practicas'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['Laboratorios'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['Talleres'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['Actividades_clinicas'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['Actividades_terreno'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['Tareas'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['Estudios'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">{{$m['Horas_semanales']}}</td>
                <td style="text-align: center">{{$m['Horas_totales']}}</td>
                <td style="text-align: center">{{$m['Creditos']}}</td>

            </tr>

            @endforeach
            </tbody>
    </table>



</body>
</html>