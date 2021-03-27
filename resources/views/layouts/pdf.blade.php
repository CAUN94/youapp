<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">

    </style>
</head>
<body>
    <header>
        <div class="right">
            <span>You</span>
            <p>Av. Apoquindo 4900, Local 7</p>
            <p>Teléfono 56933809726</p>
        </div>

    </header>
    <main>
        <div class="first">
            Impreso: <span id="date">{{$now}}</span><br>
            {{$professional->name}} , RUN {{$professional->rut}}<br>
            Paciente: {{$patient->Nombre_paciente}} {{$patient->Apellidos_paciente}}, RUN {{$patient->Rut_Paciente}}
        </div>
        <div class="second">
            <br>
            Se acredita que el paciente {{$patient->Nombre_paciente}} {{$patient->Apellidos_paciente}}, RUN {{$patient->Rut_Paciente}}, tiene una atención en nuestra clínica el día {{$patient->Fecha}} a las {{$patient->Hora_inicio}} hrs.
        </div>
    </main>

</body>
</html>
