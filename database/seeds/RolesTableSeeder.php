<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Administrador',
                'slug' => 'admin',
                'description' => 'Administrador General',
                'created_at' => '2020-05-25 00:00:00',
                'updated_at' => '2020-05-25 00:00:00',
                'special' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Instructor',
                'slug' => 'instructor',
                'description' => 'Solo puede administrar sus propios cursos',
                'created_at' => '2020-05-25 00:00:00',
                'updated_at' => '2020-05-25 00:00:00',
                'special' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'name' => 'Alumno',
                'slug' => 'alumno',
                'description' => 'Consumidor de los cursos',
                'created_at' => '2020-05-25 00:00:00',
                'updated_at' => '2020-05-25 00:00:00',
                'special' => NULL,
            ),
        ));
        
        
    }
}