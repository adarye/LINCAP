

function FullScreen() {
    var element = document.documentElement;
    if (element.requestFullScreen) {
        element.requestFullScreen();
    } else if (element.mozRequestFullScreen) {
        element.mozRequestFullScreen();
    } else if (element.webkitRequestFullScreen) {
        element.webkitRequestFullScreen();
    }
}

function cancelFullscreen() {
    if (document.cancelFullScreen) {
        document.cancelFullScreen();
    } else if (document.mozCancelFullScreen) {
        document.mozCancelFullScreen();
    } else if (document.webkitCancelFullScreen) {
        document.webkitCancelFullScreen();
    }
}

function del(id, controlador, msn) {
    console.log(id);
    $.msgbox("¿ Está seguro que desea borrar el registro ? <br />" + msn, {
        type: "confirm",
        buttons: [
            {type: "submit", value: "Aceptar"},
            {type: "cancel", value: "Cancelar"}
        ]
    }, function (result) {
        if (result === "Aceptar") {
            window.location.href = controlador + id;
        }
    });
}

function est(id, controlador, msn) {
    console.log(id);
    $.msgbox("¿ A qué estado desea cambiar el paciente " + msn + " ?", {
        type: "confirm",
        buttons: [
            {type: "submit", value: "Activo"},
            {type: "submit", value: "Salida"},
            {type: "submit", value: "No via oral"},
            {type: "cancel", value: "Cancelar"}
        ]
    }, function (result) {

        activo = 1;
        salida = 2;
        nvo = 3;

        if (result === "Activo") {
            window.location.href = controlador + id + "/" + activo;
        }
        if (result === "Salida") {
            window.location.href = controlador + id + "/" + salida;
        }
        if (result === "No via oral") {
            window.location.href = controlador + id + "/" + nvo;
        }
    });
}


$(document).ready(function () {


    var handleDataTableButtons = function () {
        if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
                dom: "Bfrtip",
                buttons: [
                    {
                        extend: "copy",
                        className: "btn-sm"
                    },
                    {
                        extend: "csv",
                        className: "btn-sm"
                    },
                    {
                        extend: "excel",
                        className: "btn-sm"
                    },
                    {
                        extend: "pdfHtml5",
                        className: "btn-sm"
                    },
                    {
                        extend: "print",
                        className: "btn-sm"
                    },
                ],
                responsive: true
            });
        }
    };


    $('.fecha').daterangepicker({
        "locale": {
            "format": "yyyy/mm/dd"
        },
        singleDatePicker: true,
        calender_style: "picker_4"
    });

    TableManageButtons = function () {
        "use strict";
        return {
            init: function () {
                handleDataTableButtons();
            }
        };
    }();

    $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
        $.fn.dataTable.tables({visible: true, api: true}).columns.adjust();
    });

    $('table.display').DataTable({
        stateSave: true,
        scrollY: false,
        scrollCollapse: true,
        paging: true,
        responsive: true
    });
    
    $('#reporte_piso').DataTable({
        dom: 'Bfrtip',
        buttons: [
            'copy', 'excel', 'pdf'
        ]		
    });	

    $('#datatable').dataTable({
        stateSave: true,
        focus: ':eq(0)',
        order: [[0, "asc"]]
    });
    $('div.dataTables_filter input').focus();
    
    $('#datatable_registro').dataTable({
        order: [[3, "desc"]]
    });
    
    $('#datatable-keytable').DataTable({
        keys: true
    });

    $('#datatable-scroller').DataTable({
        ajax: "js/datatables/json/scroller-demo.json",
        deferRender: true,
        scrollY: 380,
        scrollCollapse: true,
        scroller: true
    });

    var table = $('#datatable-fixed-header').DataTable({
        fixedHeader: true
    });

    TableManageButtons.init();

    $(".iframe").colorbox({
        iframe: true,
        width: "60%",
        height: "70%"
    });

    $(".iframe_foto").colorbox({
        iframe: true,
        width: "39%",
        height: "60%"
    });

    $(".iframe_perfil").colorbox({
        iframe: true,
        width: "45%",
        height: "38%"
    });

    $(".iframe_print").colorbox({
        iframe: true,
        width: "30%",
        height: "60%"
    });

    $(".select").select2({
        allowClear: true
    });

    $('.demo1').colorpicker();
    $('.demo2').colorpicker();

    $('#demo_forceformat').colorpicker({
        format: 'rgba',
        horizontal: true
    });

    $('#demo_forceformat3').colorpicker({
        format: 'rgba',
    });

    $('.demo-auto').colorpicker();


});



$("#torres").change(function (event) {
    $.get("/pisoanidado/" + event.target.value + "", function (response, torres) {
        $("#pisos").empty();
        if (response.length !== 0) {
            $("#pisos").append("<option value=''>Seleccione un piso</option>");
            for (i = 0; response.length > i; i++) {
                $("#pisos").append("<option value='" + response[i].id + "'>" + response[i].nombre + "</option>");
            }
        } else {
            $("#pisos").append("<option value=''> No hay registros </option>");
        }
    });
});

$("#tipo").change(function (event) {
    if (event.target.value === '1') {
        $("#time_eat").empty();
        $("#time_eat").append("<option value='" + 1 + "'> Desayuno </option>");
        $("#time_eat").append("<option value='" + 2 + "'> Almuerzo </option>");
        $("#time_eat").append("<option value='" + 3 + "'> Comida </option>");
    }
    if (event.target.value === '2') {
        $("#time_eat").empty();
        $("#time_eat").append("<option value='" + 4 + "'> Media mañana </option>");
        $("#time_eat").append("<option value='" + 5 + "'> Media tarde </option>");
        $("#time_eat").append("<option value='" + 6 + "'> Cena </option>");
    }

});

$("#frm").validator();
$.fn.validator.Constructor.FOCUS_OFFSET;