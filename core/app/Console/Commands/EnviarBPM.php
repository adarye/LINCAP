<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Terceros;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use App\Mail\CursoBPM;

class EnviarBPM extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emp:enviarBPM';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $time =new Carbon();
        $fecha = $time->addDays(7);
       
        
        $fecha = $fecha->format('Y-m-d');
        $empleados =  Terceros::select(
            "c0541_rowid",
            "c0541_nombres",
            "c0541_id",
            "c0541_apellido1",
            "c0541_apellido2",
            "c0540_fecha_nacimiento",
            "c0550_fecha_ingreso",
            "c0763_descripcion",
            "c0550_rowid_tercero",
            "c0550_fecha_contrato_hasta",
            "f285_descripcion",
            "f285_id",
            "cz9_mail_corp",
            "cz9_tel_corp",
            "cz9_cel_corp",
            "cz9_fv_carne_vacunacion"
            


        )->join(
            'dbo.w0540_empleados',
            'dbo.w0541_terceros_seleccion.c0541_rowid',
            '=',
            'dbo.w0540_empleados.c0540_rowid_prospecto'

        )->join(
            'dbo.w0550_contratos',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.w0550_contratos.c0550_rowid_tercero'

        )->join(
            'dbo.w0763_gh01_cargos',
            'dbo.w0763_gh01_cargos.c0763_rowid',
            '=',
            'dbo.w0550_contratos.c0550_rowid_cargo'

        )->join(
            'dbo.t284_co_ccosto',
            'dbo.w0550_contratos.c0550_rowid_ccosto',
            '=',
            'dbo.t284_co_ccosto.f284_rowid'

        )->join(
            'dbo.t285_co_centro_op',
            'dbo.w0550_contratos.c0550_id_co',
            '=',
            'dbo.t285_co_centro_op.f285_id'

        )->join(
            'dbo.z9_empleados_info',
            'dbo.w0540_empleados.c0540_rowid_tercero',
            '=',
            'dbo.z9_empleados_info.cz9_id_empleado'

         )
            ->where('c0550_ind_estado', '1')
            ->where(
                'cz9_fv_bpm',  $fecha
            )->get();
             
       if($empleados != '[]'){
        Mail::to('adavidparra0412@gmail.com')->send(new CursoBPM($empleados, $fecha));
    }

    }
}
