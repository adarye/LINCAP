<html>
    <head>

    </head>
    <body>
        <div>
            <p class="titulo" id="e">
                <b>Cordial saludo,</b>
            <br>
         A esto(s) empleados les diremos adiós dentro de 8 días
        </p>
            
            @foreach($empleados as $emp)
            <ul>
                <li><b> {{$emp->c0541_id}} | </b> <b>{{$emp->c0541_nombres }} {{$emp->c0541_apellido1 }} {{$emp->c0541_apellido2 }}  | </b> <b>{{$emp->c0763_descripcion}}  |</b>  {{\Carbon\Carbon::parse($emp->c0550_fecha_contrato_hasta)->format('d/m/Y')  }} </li>
            </ul>
            @endforeach
        </div>
    </body>
</html>