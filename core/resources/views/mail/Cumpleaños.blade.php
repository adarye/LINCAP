<html>
    <head>

    </head>
    <body>
        <div>
            <p class="titulo" id="e">
            <b>HOLA {{$empleado->c0541_nombres}}</b>
            <br>
            En este dia tan especial {{\Carbon\Carbon::now()->format('d/m/Y')}}, queremos agradecerte 
        </p>
        {{-- {{$empleados}} --}}
            
            {{-- @foreach($empleados as $emp)
            <ul>
                <li><b> {{$emp->c0541_id}} | </b> <b>{{$emp->c0541_nombres }} {{$emp->c0541_apellido1 }} {{$emp->c0541_apellido2 }}  | </b> <b>{{$emp->c0763_descripcion}}  |</b>  {{\Carbon\Carbon::parse($emp->c0540_fecha_nacimiento)->format('d/m/Y')  }} </li>
            </ul>
            @endforeach --}}
        </div>
    </body>
</html>