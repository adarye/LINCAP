<!DOCTYPE html>
<html lang="es">

<head>
    @include('layouts.meta')
    @include('layouts.css')
    <title>Lincap | @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ url('/theme/images/system/favicon.ico') }}" />
</head>

<body class=".bg-info">
    <div id="app">
        <div class="container">
           <Login></Login>
        </div>
    </div>
    @include('layouts.js')
</body>

</html>
