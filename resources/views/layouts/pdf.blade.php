<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style type="text/css">
        header {
            height: 100px;
            width: 60%;
        }
        header img{
            width: 200px;
            display: inline;
        }
        header div {
            margin: 0;
            float: right;
            display: inline;
        }

        div p{
            margin: 0;
            text-align: center;
        }

        div p span{
            font-weight: bold;
        }

        .first span {
            font-weight: bold;
        }

        .second {
            margin-top: 20px;
            text-align: center;
        }


    </style>
</head>
<body>
    <header>
        <img src="https://cdn.fs.teachablecdn.com/2OJfrvxiQTaLOw1tWA28">
        <div>
            <p><span>You</span></p>
            <p>Av. Apoquindo 4900, Local 7</p>
            <p>Teléfono 56933809726</p>
        </div>

    </header>
    <main>
        <div class="first">
            Impreso: <span>{{$now}}</span><br>
            <span>{{$professional->name}} , RUN {{$professional->rut}}</span><br>
            <span>Paciente: {{$patient->Nombre_paciente}} {{$patient->Apellidos_paciente}}, RUN {{$patient->Rut_Paciente}}</span>
        </div>
        <div class="second">
            Se acredita que el paciente {{$patient->Nombre_paciente}} {{$patient->Apellidos_paciente}}, RUN {{$patient->Rut_Paciente}}, tiene una atención en nuestra clínica el día {{$patient->Fecha}} a las {{$patient->Hora_inicio}} hrs.
        </div>
    </main>

</body>
</html>
