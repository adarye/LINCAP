<?php

use Illuminate\Database\Seeder;

use App\z1_usuarios;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        z1_usuarios::create([
            'cz1_cc' => '1102376580',
            'cz1_nombres' => 'JEFFERSON QUINTERO RINCON',
            'password' => bcrypt('12121212'),
            'cz1_id_rol' => 1,
            'cz1_id_empleado' => 4547,
            'cz1_avatar' => 'user.png'
        ]);
        z1_usuarios::create([
            'cz1_cc' => '1005190052',
            'cz1_nombres' => 'ADOLFO DAVID PARRA CASTAÑO',
            'password' => bcrypt('12121212'),
            'cz1_id_rol' => 1,
            'cz1_id_empleado' => 15551,
            'cz1_avatar' => 'user.png'
        ]);
    }
}
