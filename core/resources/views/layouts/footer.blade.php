<!-- footer content -->
<footer>
    <div class="pull-right">
        Desarrollado por
        <a class="con_imagen" >
             <b>David Parra & Jefferson Quintero Rincón</b>
            <img style="width: 160px; height: 150px" src="https://contenidos.enter.co/custom/uploads/2010/11/googles.jpg">
          </a>
        {{-- Desarrollado por <b>David Parra & Jefferson Quintero Rincón</b> --}}
    </div>
    <div class="pull-left">
        <?php 
        $date = \Carbon\Carbon::now(); 
        $year = $date->year;
        ?>
        Copyright © {{$year }} <a href="https://www.linco.com.co">LINCO</a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
