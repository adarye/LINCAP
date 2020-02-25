<html>
    <head>

    </head>
    <body>
        <div>
            <p class="titulo" id="e">
                <b>Cordial saludo,</b>
            <br>
         Estos contratos finalizaran entre {{$date_principio->addDays(1)->format('d/m/Y') }}, y {{$date_final->subDays(1)->format('d/m/Y') }}
        </p>

        @if ($empleados == null || $empleados == [])
        <p>N</p>
        @endif
            
            @foreach($empleados as $emp)
            <ul>
                <li>{{$emp->c0541_nombres }} <b> | </b> {{\Carbon\Carbon::parse($emp->c0550_fecha_contrato_hasta)->format('d/m/Y')  }} </li>
                {{-- <li>{{\Carbon\Carbon::parse($emp->c0550_fecha_contrato_hasta)->format('d/m/Y')  }}</li> --}}
            </ul>
            @endforeach
        </div>
    </body>
</html>