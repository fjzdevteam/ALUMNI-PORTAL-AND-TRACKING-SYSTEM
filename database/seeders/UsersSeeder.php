<?php


namespace Database\Seeders;


use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class UsersSeeder extends Seeder
{


    public function run(): void
    {
        DB::table('users')->insert([
            [
                'username' => 'rommeljohn',
                'password' => Hash::make('Aballe01!'),
                'last_name' => 'Aballe',
                'first_name' => 'Rommel John',
                'middle_name' => 'Lampas',
                'suffix' => null,
                'email' => 'aballe_rommeljohn@plpasig.edu.ph',
                'role' => 'admin',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'username' => 'zhanie',
                'password' => Hash::make('Zhanie09!'),
                'last_name' => 'Chavez',
                'first_name' => 'Zhan Lexie',
                'middle_name' => 'Magdayao',
                'suffix' => null,
                'email' => 'zhanlexiechavez@gmail.com',
                'role' => 'alumni',
                'status' => 'active',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
