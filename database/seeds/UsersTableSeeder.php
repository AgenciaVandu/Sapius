<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('users')->delete();

        \DB::table('users')->insert(array (
            0 =>
            array (
                'id' => 1,
                'username' => 'mecanul',
                'nombre' => 'Miguel Eduardo',
                'apellido' => 'Canul Euan',
                'email' => 'lalo.ce@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => 'X0J4ep5Jc2Mu957eiWd6aTpFLN1ehjfpWw9v31pV9NYZCbGkDEU5RscEfndl',
                'session_id' => 'lQlZ6oBadPKOULeA0l9l5QIFF3ZwRpE4zjBscIeF',
                'activo' => 'si',
                'created_at' => '2020-05-23 21:51:32',
                'updated_at' => '2020-07-30 03:19:10',
            ),
            1 =>
            array (
                'id' => 2,
                'username' => 'acanul',
                'nombre' => 'Arturo Canul',
                'apellido' => 'Canul Euan',
                'email' => 'artur0@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => NULL,
                'session_id' => NULL,
                'activo' => 'no',
                'created_at' => '2020-05-23 21:51:32',
                'updated_at' => '2020-05-23 21:51:32',
            ),
            2 =>
            array (
                'id' => 3,
                'username' => 'adcanul',
                'nombre' => 'Angel Daniel',
                'apellido' => 'Canul Euan',
                'email' => 'angel_daniel@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => NULL,
                'session_id' => NULL,
                'activo' => 'no',
                'created_at' => '2020-05-23 21:51:32',
                'updated_at' => '2020-07-18 19:29:10',
            ),
            3 =>
            array (
                'id' => 4,
                'username' => 'meuan',
                'nombre' => 'Maria',
                'apellido' => 'Euan',
                'email' => 'skyla301@example.net',
                'email_verified_at' => NULL,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => NULL,
                'session_id' => 'nfYJkkx8DRhT5nvaCUEkS7Ap8WcsafithW7feTGQ',
                'activo' => 'no',
                'created_at' => '2020-05-25 23:45:14',
                'updated_at' => '2020-07-30 03:29:16',
            ),
            4 =>
            array (
                'id' => 5,
                'username' => 'seuan',
                'nombre' => 'selmi',
                'apellido' => 'euan',
                'email' => 'schimmel.rigoberto@example.net',
                'email_verified_at' => NULL,
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'remember_token' => NULL,
                'session_id' => 'DTyArdyd0FDGLvkL7ye9xiqSrMcvKz70fuSzEyD3',
                'activo' => 'no',
                'created_at' => '2020-05-25 23:49:04',
                'updated_at' => '2020-07-27 20:17:14',
            ),
            5 =>
            array (
                'id' => 6,
                'username' => 'alvar',
                'nombre' => 'Alvar',
                'apellido' => 'Buenfil',
                'email' => 'alvarbu@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$Psuz.p52EhzG./kt7DhKTuw6yhnFqTYLTEsSwsRd6zHjLCubezH0W',
                'remember_token' => NULL,
                'session_id' => 'wrTg5q60gz43q6MVXLus5EtG06hwxHg4ZklTcffu',
                'activo' => 'si',
                'created_at' => '2020-07-28 14:35:13',
                'updated_at' => '2020-07-29 16:13:35',
            ),
            6 =>
            array (
                'id' => 7,
                'username' => 'vero',
                'nombre' => 'Veronica',
                'apellido' => 'Gonzales',
                'email' => 'vero@gmail.com',
                'email_verified_at' => NULL,
                'password' => '$2y$10$L7s7mBLNRkVJfJWKnrTIPeph95JSwUl/DdTJPa5g4/zC6kI1mCvpi',
                'remember_token' => NULL,
                'session_id' => NULL,
                'activo' => 'no',
                'created_at' => '2020-07-28 16:02:21',
                'updated_at' => '2020-07-28 16:05:56',
            ),
        ));


    }
}
