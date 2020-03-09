<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Certificado laboral</title>
    <style type="text/css">
        .upn {
            /* background-image:url("https://www.portalempleo.linco.com.co/fotos/fondo_default.png"); */
            /* width: 450px;
            height: 350px; */
            position: absolute;
            bottom: -370px;
            right: 280px;
            opacity: .400;
        }

        .logo {
            height: 75px;
            width: 240px;
        }

        .titulo {
            color: black;
            font-weight: bold;
            font-size: 17px;
            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            margin-top: 25px;
        }

        .p {
            color: black;
            /* font-weight: bold; */

            font-family: Century Gothic, CenturyGothic, AppleGothic, sans-serif;
            margin-top: 25px;
        }

        .iso {
            height: 80px;
            width: 50px;
        }

        .box {
            position: absolute;
            bottom: 35px;
           

        }
        .box2 {
            position: absolute;
            bottom: 35px;
            right: 5px;
           

        }
        .cer{
        font-size: 10px;
        }

    </style>
</head>

<body>


    <img class="logo" src="http://lincapd/theme/images/system/logo_linco_horizontal.jpg" alt="">

    <div align="center" class="titulo">
        LA COORDINADORA DE GESTION HUMANA DE
        <br>
        LOGISTICA INSTITUCIONAL COLOMBIANA - LINCO S.A.S
        <br>
        NIT. 900.127.675 - 2
        <br><br><br><br>
        CERTIFICA QUE:
        <br><br><br><br>
    </div>
    
    <p class="p" align="justify">
        El (la) señor (a), {{ $empleado->c0541_nombres }} {{ $empleado->c0541_apellido1 }}
        {{ $empleado->c0541_apellido2 }}, identificado (a) con cédula de ciudadanía número {{ $empleado->c0541_id }}
        expedida en {{ $empleado->f013_descripcion }}, se encuentra vinculado (a) a LINCO S.A.S desde
        {{ \Carbon\Carbon::parse($empleado->c0550_fecha_ingreso)->format('d/m/Y')  }},
        desempeñando actualmente el cargo de {{ $empleado->c0763_descripcion }}, con contrato
        Termino Fijo, renovable, el cual a la fecha se encuentra vigente hasta el
        {{ \Carbon\Carbon::parse($empleado->c0550_fecha_contrato_hasta)->format('d/m/Y')  }}, devengando un salario
        mensual de {{ NumeroALetras::convertir($empleado->c0550_salario, 'pesos', false)}}
         M/CTE (${{ number_format($empleado->c0550_salario) }}),
        más todas las prestaciones legales vigentes.
        <br><br>
        Se expide en la ciudad de Floridablanca, a solicitud del interesado el {{ $date }}.
        <br><br>
        Atentamente,
        <br><br><br><br>
        <div class="p">
            <div align="center">
                BETSABE ROMERO RINCON
                <br>
                <b>Coordinadora de Gestión Humana</b>
            </div>
            <br><br>
            <b>Elaboró:</b> Luz Nuñez
            <br>
            <b>Reviso:</b> Betsabe Romero
    </p>
    </div>
    </div>
    <div class="box">
        <span>
        <img class="iso" src="http://lincapd/theme/images/system/ISO9001.png" alt="">
        
        </span>
        <span>
        <img class="iso" src="http://lincapd/theme/images/system/ISO14001.png" alt="">
        
        </span>
    <span>
        <img class="iso" src="http://lincapd/theme/images/system/ISO18001.png" alt="CERTIFICADO">
        
    </span>
    <span>
        <img style="height: 60px;
        width: 65px;" src="http://lincapd/theme/images/system/iqnet.png" alt="CERTIFICADO">
        
    </span>
    </div>
    <img class="upn" src="http://lincapd/theme/images/system/fondo.jpg">
    <div class="box2" align="justify">
        
           <b>Telefax:  </b>   (57)(7)648 48 91 <br>
      <b> Dirección: </b> Carrera 4 No. 5-04 <br>
      (Antigua licorera de Sder)<br>
       <b style="color: orange;">+Floridablanca +Santander +Colombia</b>
       
    </div>

</body>

</html>
