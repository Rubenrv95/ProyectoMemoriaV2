<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Plan de Estudio</title>
</head>
<body>


    <h1>Competencias</h1>
    @foreach ($competencia as $c)
    <h3>{{$c['Descripcion']}}</h3>
    @endforeach

    <h1>Aprendizajes</h1>

    @foreach ($aprendizaje as $a)
    <h3>{{$a['Descripcion_aprendizaje']}}</h3>
    @endforeach

    <h1>Saberes Conocer</h1>

    @foreach ($saber_conocer as $sc)
    <h3>{{$sc['Descripcion_saber']}}</h3>
    @endforeach

    <h1>Saberes Hacer</h1>

    @foreach ($saber_hacer as $sh)
    <h3>{{$sh['Descripcion_saber']}}</h3>
    @endforeach

</body>
</html>