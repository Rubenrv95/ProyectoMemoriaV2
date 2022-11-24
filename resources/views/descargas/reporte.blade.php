<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Reporte de Plan de Estudio</title>
</head>
<body>
    
    <h3 style="text-align: center">Universidad de Talca</h3>
    @foreach ($carrera_seleccionada as $car)
    <h1 style="text-align: center">Resumen Plan de Estudio {{$car['nombre']}}</h1>
    @endforeach

    <p style="font-weight: bold">Nombre de la carrera: {{$car['nombre']}}</p>
    <p style="font-weight: bold">Facultad: {{$car['facultad']}}</p>
    <p style="font-weight: bold">Formación: {{$car['formacion']}}</p>
    <p style="font-weight: bold">Tipo: {{$car['tipo']}}</p>
    <p></p>
    <p>A continuación, se presenta un reporte de toda la información de la carrera de {{$car['nombre']}}, incluyendo
        competencias, aprendizajes, saberes y módulos asociados.
    </p>

    <h2>Competencias</h2>

    <table border="1" style='border-collapse: collapse; text-align: center; margin-right: auto; margin-left: auto' >
        <thead>
            <tr>
                <td>Orden</td>
                <td style="width: 100%">Descripción de Competencia</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($competencia as $c)
            <tr>
                <td>{{$c['orden']}}</td>
                <td style="word-wrap: break-word; max-width: 0;">{{$c['descripcion']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always"></div>

    <h2>Temporalización de Competencias</h2>

    <table border="1" style='border-collapse: collapse; text-align: center; margin-right: auto; margin-left: auto' >
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
                <td style="word-wrap: break-word; max-width:0;">{{$tc['orden']}}. {{$tc['descripcion']}}</td>
                @for ($i = 1; $i <= 14; $i++)
                    <td  style="text-align: center"> 
                        @if ($tc['nivel_'.$i]== 1) 
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

    <table border="1" style='border-collapse: collapse; text-align: center; margin-right: auto; margin-left: auto'>
        <thead>
            <tr>
                <td>Competencia asociada</td>
                <td>Dimensión asociada</td>
                <td>Descripción de Aprendizaje</td>
                <td>Nivel de aprendizaje</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($aprendizaje as $a)
            <tr>
                <td rowspan="1" style="word-wrap: break-word; max-width:0;">{{$a['OrdenComp']}}. {{$a['descripcion']}}</td>
                <td rowspan="1" style="word-wrap: break-word; max-width:0;">{{$a['orden']}}. {{$a['descripcion_dimension']}}</td>
                <td rowspan="1" style="word-wrap: break-word; max-width:0;">{{$a['descripcion_aprendizaje']}}</td>
                <td rowspan="1">{{$a['nivel_aprend']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always"></div>

    <h2>Temporalización de Aprendizajes</h2>

    <table border="1" style='border-collapse: collapse; text-align: center; margin-right: auto; margin-left: auto' >
        <thead>
            <tr>
                <td>Competencia asociada</td>
                <td>Nivel de Aprend.</td>
                <td>Desc. de Aprendizaje</td>
                <td>Dimensión asociada</td>
                @for ($i = 1; $i <= 14; $i++)
                    <td>{{$i}}</td>
                @endfor
            </tr>
        </thead>
        <tbody>
        @foreach ($tempo_aprendizaje as $ta)
            <tr>
                <td style="word-wrap: break-word; max-width:0;">{{$ta['OrdenComp']}}. {{$ta['descripcion']}}</td>
                <td >{{$ta['nivel_aprend']}}</td>
                <td style="word-wrap: break-word; max-width:0;">{{$ta['descripcion_aprendizaje']}}</td>
                <td style="word-wrap: break-word; max-width:0;">{{$ta['orden']}}. {{$ta['descripcion_dimension']}}</td>
                @for ($i = 1; $i <= 14; $i++)
                    <td  style="text-align: center"> 
                        @if ($ta['nivel_'.$i]== 1) 
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

    <table border="1" style='border-collapse: collapse; text-align: center; margin-right: auto; margin-left: auto'>
        <thead>
            <tr>
                <td>Competencia asociada</td>
                <td>Dimensión asociada</td>
                <td>Aprendizaje asociado</td>
                <td>Descripción de Saber</td>
                <td>Tipo de Saber</td>
                <td>Nivel</td>
            </tr>
        </thead>
        <tbody>
        @foreach ($saber as $s)
            <tr>
                <td rowspan="1" style="word-wrap: break-word; max-width:0;">{{$s['OrdenComp']}}. {{$s['descripcion']}}</td>
                <td rowspan="1" style="word-wrap: break-word; max-width:0;">{{$s['OrdenDim']}}. {{$s['descripcion_dimension']}}</td>
                <td rowspan="1" style="word-wrap: break-word; max-width:0;">{{$s['descripcion_aprendizaje']}}</td>
                <td rowspan="1" style="word-wrap: break-word; max-width:0;">{{$s['descripcion_saber']}}</td>
                <td rowspan="1">{{$s['tipo']}}</td>
                <td rowspan="1">{{$s['nivel']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div style="page-break-after: always"></div>

    <h2>Carga Académica</h2>

    <table border="1" style='border-collapse: collapse; text-align: center; margin-right: auto; margin-left: auto'>
        <thead style="text-align: center">

            <tr>
                <th rowspan="2"style="text-align: center">Semestre</th>
                <th rowspan="2"style="text-align: center">Módulo</th>
                <th rowspan="2"style="text-align: center">Tipo Curso</th>
                <th rowspan="2"style="text-align: center;">Clases</th>
                <th rowspan="2"style="text-align: center;">SEM</th>
                <th rowspan="2" style="text-align: center;">AYU</th>
                <th colspan="3">Act. Prácticas o Laboratorio</th>
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
                <td style="text-align: center">{{$m['semestre']}}</td>
                <td style="text-align: center; word-wrap: break-word; max-width:0;">{{$m['nombre_modulo']}}</td>
                <td style="text-align: center">{{$m['tipo']}}</td>
                <td style="text-align: center">
                    @if ($m['clases'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>

                <td style="text-align: center">
                    @if ($m['seminario'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['ayudantias'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['actividades_practicas'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['laboratorios'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['talleres'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['actividades_clinicas'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['actividades_terreno'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['tareas'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">
                    @if ($m['estudios'] == 1)
                        X
                    @else
                        
                    @endif                          
                </td>
                <td style="text-align: center">{{$m['horas_semanales']}}</td>
                <td style="text-align: center">{{$m['horas_totales']}}</td>
                <td style="text-align: center">{{$m['creditos']}}</td>

            </tr>

            @endforeach
            </tbody>
    </table>



</body>
</html>