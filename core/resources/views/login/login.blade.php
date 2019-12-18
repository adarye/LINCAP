<!DOCTYPE html>
<html lang="es">

<head>
    @include('layouts.meta')
    @include('layouts.css')
    <title>Lincap | Login</title>
    <link rel="icon" type="image/png" href="{{ url('/theme/images/system/favicon.ico') }}" />
</head>

<body class="login">
    <div id="app">
      <a class="hiddenanchor" id="signup"></a>
      <a class="hiddenanchor" id="signin"></a>

      <div class="login_wrapper">
        <div class="animate form login_form">
          <section class="login_content">
            <form>
              <h1>Login Lincap</h1>
              <Login></Login>

              <div class="clearfix"></div>

              <div class="separator">
                <div class="clearfix"></div>
                <br />

                <div>
                  <h1><i class=""></i> by Linco</h1>
                  <p>©2019 Todos los derechos reservados.</p>
                </div>
              </div>
            </form>
          </section>
        </div>

      </div>
    </div>
    @include('layouts.js')
  </body>

</html>
