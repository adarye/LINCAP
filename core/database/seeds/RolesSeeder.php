<?php

use Illuminate\Database\Seeder;

use App\z2_roles;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       z2_roles::create([
            'cz2_nombre' => 'ADMIN',
            'cz2_descripcion' => 'ADMIN'
        ]);
        z2_roles::create([
            'cz2_nombre' => 'RRHH',
            'cz2_descripcion' => 'RRHH'
        ]);
        z2_roles::create([
            'cz2_nombre' => 'SST',
            'cz2_descripcion' => 'SST'
        ]);
        z2_roles::create([
            'cz2_nombre' => 'DEFAULT',
            'cz2_descripcion' => 'DEFAULT'
        ]);
        z2_roles::create([
            'cz2_nombre' => 'ADMINISTRATIVO',
            'cz2_descripcion' => 'ADMINISTRATIVO'
        ]);
        z2_roles::create([
            'cz2_nombre' => 'JEFES',
            'cz2_descripcion' => 'JEFES'
        ]);
       
    }
}
