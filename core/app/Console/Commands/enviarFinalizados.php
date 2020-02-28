<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\Diario;
use App\Terceros;
use Carbon\Carbon;

class enviarFinalizados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'emp:contrato';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia unos correos de los proximos trabajadores que finalizan su contrato';

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
        $date= Carbon::now();
        $date2= Carbon::now();
        $date_principio =$date->addDays(6);
         $date_final = $date2->addDays(7);

       $empleados = Terceros::select(
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
            "f285_id"

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

        )
            ->where('c0550_ind_estado', '1')
            ->where('c0550_fecha_contrato_hasta','>=', $date_principio)
            ->where('c0550_fecha_contrato_hasta','<=', $date_final)
            ->orderBy('c0550_fecha_contrato_hasta', 'ASC')
            ->get();

             if($empleados != '[]' ){
                Mail::to('sistemas@linco.com.co')->send(new Diario($empleados,  $date_principio, $date_final));
             }
        
    }
}
