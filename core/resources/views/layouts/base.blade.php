<!DOCTYPE html>
<html lang="es">

<head>
    @include('layouts.meta')
    @include('layouts.css')
    <title>Lincap | @yield('title')</title>
    <link rel="icon" type="image/png" href="{{ url('/theme/images/system/favicon.ico') }}" />
</head>

<body class="nav-md">
    <div id="app">
        <div class="container body">
            <div class="main_container">
                <div class="col-md-3 left_col">
                    <div class="left_col scroll-view">
                        <a href="{{ url ('#') }}"><img alt="" class="img-circle empresa-logo"
                                src="{{ url('/theme/images/system/logo_linco_vertical.jpg') }}"></a>
                        <p class="empresa-text profile">[ Lincap ]<br>
                            LOGISTICA INSTITUCIONAL COLOMBIANA S.A.S</p>
                        <div class="clearfix"></div>
                        @include('layouts.profile')
                        @include('layouts.menu')
                    </div>
                </div>
                @include('layouts.header')
                <!-- page content -->
                <div class="right_col" role="main">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="dashboard_graph">
                                <div class="row text-center">
                                    @yield('breadcum')
                                </div>
                                @yield('content')
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                    <br>
                </div>
                <!-- page content -->
                @include('layouts.footer')
            </div>
        </div>
    </div>
    @include('layouts.js')
</body>

</html>
