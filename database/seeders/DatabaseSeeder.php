<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use App\Models\User; 

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
       
        User::updateOrCreate(
            ['email' => 'admin@itsm.com'], 
            [
                'name' => 'Administrator',
                'password' => bcrypt('password123'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'user@itsm.com'],
            [
                'name' => 'Karyawan Staff',
                'password' => bcrypt('password123'),
                'role' => 'user',
            ]
        );

        User::updateOrCreate(
            ['email' => 'manager@itsm.com'],
            [
                'name' => 'Bapak Manager',
                'password' => bcrypt('password123'),
                'role' => 'manager',
            ]
        );

        User::updateOrCreate(
            ['email' => 'headit@itsm.com'],
            [
                'name' => 'Kepala IT',
                'password' => bcrypt('password123'),
                'role' => 'it_head',
            ]
        );
    }
}