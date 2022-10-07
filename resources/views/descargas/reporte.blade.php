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



</body>
</html>