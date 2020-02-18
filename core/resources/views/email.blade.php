<html>

<head>
</head>

<body>

    <p class="titulo" id="e">
    Estimado/a, {{ $datos->cz1_nombres }}:<br><br>
    
    Hemos recibido una solicitud para cambiar la contraseña de su cuenta de LINCAP. <br>
    Copia el token para completar esta solicitud. <br><br>
    
    Token: <b>{{ $token }}</b><br><br>

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
