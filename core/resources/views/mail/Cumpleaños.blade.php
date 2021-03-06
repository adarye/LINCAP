{{-- <!DOCTYPE html>
<html>
<head>
 <title>Happy Birthday</title>
 <meta charset="utf-8" />
 <style type="text/css">
    #birthdayCard {
        background: orange;
  color: #111111;
  width: 25%;
  min-width: 300px;
  border: 8px solid orange;
  border-left: 10px solid #DD0000;
  margin: 10px;
  padding: 20px;
}
.redText {
  color: #CC0000;
}

.signature {
  text-align: right;
}

strong {
  font-size: large;
  color: #CC0000;
}
</style>
</head>
<body>
    
    {{$fecha = \Carbon\Carbon::now()->year}}
{{$años = $fecha - \Carbon\Carbon::parse($empleado->c0540_fecha_nacimiento)->year}} --}}
{{-- {{$empleado}} --}}
{{-- <div id="birthdayCard">
  <h1><img style="width: 40px; height: 65px"  src="https://i.pinimg.com/originals/52/d2/09/52d209783f63a1c41d1f5111faf98e11.png" alt="">HAPPY BIRTHDAY, <span class="redText">{{$empleado->c0541_nombres}}</span>!
</h1>
<p>EN TUS <span class="redText">{{$años}}</span> AÑOS.</p>
<p>TE DESEAMOS GRANDES <strong>EXITOS</strong> Y <strong>MUCHA FELICIDAD</strong> PARA TU VIDA.</p>
<p>ESTAMOS CONTENTOS DE TENERTE!</p>
<p class="signature">–TU FAMILIA, <b>LINCO</b></p>
</div>

</body>

</html> --}}



<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Demystifying Email Design</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body style="margin: 0; padding: 0;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td style="padding: 10px 0 30px 0;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                    style="border: 1px solid #cccccc; border-collapse: collapse;">
                    <tr>
                        <td align="center" bgcolor="#70bbd9"
                            style="padding: 40px 0 30px 0; color: #153643; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif;">
                            <img src="https://omextemplates.content.office.net/support/templates/es-es/lt56502425.png"
                                alt="Hola" width="300" height="230" style="display: block;" />
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                        <b>
                                            <?php
                      $fecha = \Carbon\Carbon::now()->year;
                      $años = $fecha - \Carbon\Carbon::parse($empleado->c0540_fecha_nacimiento)->year;
                      ?>
                                            HOLA {{$empleado->c0541_nombres}}, FELICES {{$años}} AÑOS
                                        </b>

                                    </td>
                                </tr>
                                <tr>
                                  <img width="120" height="120" src="favicon.ico" alt="">
                                    <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                       
                                    </td> 
                                </tr>
                                <tr>
                                    <td>
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                          <td style="text-align: justify; padding: 10px 0 0 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px; font-style: oblique;">
                                                                La familia LINCO desea
                                                                que disfrutes de este día
                                                                con ilusión y en compañía
                                                                de las personas que más
                                                                amas en el mundo. Que esta nueva etapa 
                                                                venga colmada de éxitos y bendiciones,
                                                                 y que la gracia de Dios se derrame sobre ti.
                                                            </td>
                                            
                            </table>
                        </td>
                    </tr>
                    <tr>
                      <td
                          style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">

                      </td>
                  </tr>
                    <tr>
                        <td bgcolor="#ee4c50" style="padding: 30px 30px 30px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 14px;"
                                        width="75%">
                                         Copyright © 2020 <a href="https://www.linco.com.co">LINCO</a><br />
                                      
                                          Desarrollado por
                                          <b>David Parra & Jefferson Quintero Rincón</b>
                                    </td>
                                    <td align="right" width="25%">
                                        <table border="0" cellpadding="0" cellspacing="0">
                                            <tr>
                                                <td
                                                    style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                    <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/tw.gif"
                                                            alt="Twitter" width="38" height="38" style="display: block;"
                                                            border="0" />
                                                    </a>
                                                </td>
                                                <td style="font-size: 0; line-height: 0;" width="20">&nbsp;</td>
                                                <td
                                                    style="font-family: Arial, sans-serif; font-size: 12px; font-weight: bold;">
                                                    <a href="http://www.twitter.com/" style="color: #ffffff;">
                                                        <img src="https://s3-us-west-2.amazonaws.com/s.cdpn.io/210284/fb.gif"
                                                            alt="Facebook" width="38" height="38"
                                                            style="display: block;" border="0" />
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>
