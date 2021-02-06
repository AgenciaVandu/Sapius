<?php

use Illuminate\Database\Seeder;

class RoleUserTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('role_user')->delete();
        
        \DB::table('role_user')->insert(array (
            0 => 
            array (
                'id' => 1,
                'role_id' => 1,
                'user_id' => 1,
                'created_at' => '2020-05-25 00:00:00',
                'updated_at' => '2020-05-25 00:00:00',
            ),
            1 => 
            array (
                'id' => 2,
                'role_id' => 2,
                'user_id' => 2,
                'created_at' => '2020-05-25 00:00:00',
                'updated_at' => '2020-05-25 00:00:00',
            ),
            2 => 
            array (
                'id' => 3,
                'role_id' => 3,
                'user_id' => 3,
                'created_at' => '2020-05-25 00:00:00',
                'updated_at' => '2020-05-25 00:00:00',
            ),
            3 => 
            array (
                'id' => 4,
                'role_id' => 3,
                'user_id' => 4,
                'created_at' => '2020-05-25 23:45:14',
                'updated_at' => '2020-05-25 23:45:14',
            ),
            4 => 
            array (
                'id' => 5,
                'role_id' => 2,
                'user_id' => 5,
                'created_at' => '2020-05-25 23:49:04',
                'updated_at' => '2020-05-25 23:49:04',
            ),
            5 => 
            array (
                'id' => 6,
                'role_id' => 1,
                'user_id' => 6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'role_id' => 1,
                'user_id' => 7,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}