<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Certificado laboral</title>
    <style type="text/css">
       
        .upn {
          background-image:url("{{asset('logo.jpg')}} ");
          background-repeat:no-repeat;
          width:700px;
          height:342px;
          position:absolute;
       }
    </style>
</head>

<body>
    <div class="upn">
    
       {{-- <img src="/../theme/images/profile/{{ Auth()->user()->cz1_avatar }}" alt=""> --}}
       <img src="/../theme/images/system/favicon.ico" alt="">
        <div align="center">
            LA COORDINADORA DE GESTION HUMANA DE
            <br>
            LOGISTICA INSTITUCIONAL COLOMBIANA - LINCO S.A.S
            <br>
            NIT. 900.127.675 - 2
            <br><br><br><br>
            CERTIFICA QUE:
            <br><br><br><br>
        </div>
        <p align="justify">
            El (la) señor (a), {{ $empleado->c0541_nombres }} {{ $empleado->c0541_apellido1 }}
            {{ $empleado->c0541_apellido2 }}, identificado (a) con cédula de ciudadanía número {{ $empleado->c0541_id }}
            expedida en {{ $empleado->f013_descripcion }}, se encuentra vinculado (a) a LINCO S.A.S desde
            {{ \Carbon\Carbon::parse($empleado->c0550_fecha_ingreso)->format('d/m/Y')  }},
            desepeñando actualmente el cargo de {{ $empleado->c0763_descripcion }}, con contrato
            Termino Fijo, renovable, el cual a la fecha se encuentra vigente hasta el
            {{ \Carbon\Carbon::parse($empleado->c0550_fecha_contrato_hasta)->format('d/m/Y')  }}, devengando un salario mensual de {{ NumeroALetras::convertir($empleado->c0550_salario, 'pesos', false)}}
            PESOS M/CTE (${{ number_format($empleado->c0550_salario) }}),
            más todas las prestaciones legales vigentes.
            <br><br>
            Se expide en la ciudad de Floridablanca, a solicitud del interesado el {{ $date }}.
            <br><br>
            Atentamente,
            <br><br><br><br>
            <div align="center">
                BETSABE ROMERO RINCON
                <br>
                Coordinadora de Gestión Humana
            </div>
            <br><br>
            Elaboró: Luz Nuñez
            <br>
            Reviso: Betsabe Romero
        </p>
       
    </div>
</body>

</html>
