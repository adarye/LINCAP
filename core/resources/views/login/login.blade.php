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
        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content shadow-lg p-3 mb-5 bg-white rounded">
                    <form>
                        @csrf
                        <h1>Login Lincap</h1>
                        <Login></Login>

                        <div class="clearfix"></div>

                        <div class="separator">
                            <div class="clearfix"></div>
                            <br />

                            <div>
                                <h1><i class=""></i> by Linco</h1>
                                <p>Copyright © 2020 <br>
                                Todos los derechos reservados.</p>
                            </div>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script type="application/javascript">
        window.user = ""
        
    </script>
    @include('layouts.js')
</body>

</html>
