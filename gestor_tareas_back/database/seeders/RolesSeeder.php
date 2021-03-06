<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $roles = ['Usuario','Administrador'];

        for ($i = 0; $i < count($roles); $i++) {
            $rol = new Role;
            $rol->nombre = $roles[$i];
            $rol->save();
        }
    }
}
