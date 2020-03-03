<html>
    <head>

    </head>
    <body>
        <div>
            {{-- {{$empleados}} --}}
            <p class="titulo" id="e">
                <b>Cordial saludo,</b>
            <br>
            A esto(s) empleados se les vencerá el carné de vacunación entre {{$fecha}} y {{$fecha2}}
        </p>
            
            @foreach($empleados as $emp)
            <ul>
                <li><b> {{$emp->c0541_id}} | </b> <b>{{$emp->c0541_nombres }} {{$emp->c0541_apellido1 }} {{$emp->c0541_apellido2 }}  | </b> <b>{{$emp->c0763_descripcion}}  |</b>  {{$emp->cz9_fv_carne_vacunacion}} </li>
            </ul>
            @endforeach
        </div>
    </body>
</html>