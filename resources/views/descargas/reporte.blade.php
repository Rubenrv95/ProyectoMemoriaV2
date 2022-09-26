<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Plan de Estudio</title>
</head>
<body>



    @foreach ($carrera as $car)
    <h1 style="text-align: center">Resumen Plan de Estudio {{$car['nombre']}}</h1>
    @endforeach

    <p>A continuación, se presenta un reporte de toda la información de la carrera de {{$car['nombre']}}, incluyendo
        competencias, aprendizajes, saberes y módulos asociados.
    </p>

    <h2>Competencias</h2>

    <table>
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

    <h2>Aprendizajes</h2>

    <table>
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
                <td>{{$a['OrdenComp']}}. {{$a['Descripcion']}}</td>
                <td>{{$a['Descripcion_dimension']}}</td>
                <td>{{$a['Descripcion_aprendizaje']}}</td>
                <td>{{$a['Nivel_aprend']}}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h2>Saberes Conocer</h2>

    @foreach ($saber_conocer as $sc)
    <h3>{{$sc['Descripcion_saber']}}</h3>
    @endforeach

    <h2>Saberes Hacer</h2>

    @foreach ($saber_hacer as $sh)
    <h3>{{$sh['Descripcion_saber']}}</h3>
    @endforeach

</body>
</html>