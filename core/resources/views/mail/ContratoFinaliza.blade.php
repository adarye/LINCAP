<html>
    <head>

    </head>
    <body>
        <div>
            <p class="titulo" id="e">
                <b>Cordial saludo,</b>
            <br>
         Estos contratos finalizaran el {{$date_principio->addDays(1)->format('d/m/Y') }}
        </p>
            
            @foreach($empleados as $emp)
            <ul>
                <li><b> {{$emp->c0541_id}} | </b> <b>{{$emp->c0541_nombres }} {{$emp->c0541_apellido1 }} {{$emp->c0541_apellido2 }}  | </b> <b>{{$emp->c0763_descripcion}}  |</b>  {{\Carbon\Carbon::parse($emp->c0550_fecha_contrato_hasta)->format('d/m/Y')  }} </li>
            </ul>
            @endforeach
        </div>
    </body>
</html>