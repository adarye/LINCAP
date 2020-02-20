<html>

<head>
</head>

<body>

    {{-- <img src="././././theme/images/system/logo_linco_vertical.jpg" alt=""> --}}

    <p class="titulo" id="e">
    Estimado/a:<br><br>
    {{$user->cz1_nombres}}
    <br>
    Se le ha asignado una  @if($prueba->cz3_categoria == 1) encuesta @else evaluación.@endif
    <br>
    <br>
    Tema:<b>{{ $prueba->cz3_nombre}}</b>
    <br>
    <br>
    Descripción :<b>{{ $prueba->cz3_descripcion}}</b>
    <br>
    <br>
    Fecha de apertura: <b>{{ \Carbon\Carbon::parse($prueba->cz3_fecha_apertura)->format('d/m/Y  h:i:s A')}}</b>
    <br>
    <br>
    Fecha de cierre: <b>{{ \Carbon\Carbon::parse($prueba->cz3_fecha_cierre)->format('d/m/Y  h:i:s A')}}</b>
     <b></b><br><br>
    Elaborada por: <b>{{$prueba->f200_nombres . ' '. $prueba->f200_apellido1 . ' ' . $prueba->f200_apellido2}}</b>
<br><br>
    Cordial saludo, <br>
    Equipo de desarrollo <br>
    LINCO S.A.S.</p>

    <style type="text/css">
        #e {
            color: #2A3F54;
            font-size: 13px;
            font-style: italic;
        }
    </style>

</body>

</html>