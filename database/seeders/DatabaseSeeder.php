<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // <--- PENTING: Panggil Model User

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
  public function run(): void
    {
        // 1. Admin / Super User
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@itsm.com',
            'password' => bcrypt('password123'),
            'role' => 'admin',
        ]);

        // 2. User Biasa (Requester)
        User::create([
            'name' => 'Karyawan Staff',
            'email' => 'user@itsm.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
        ]);

        // 3. Manager (Function Head) - YANG AKAN APPROVE PERTAMA
        User::create([
            'name' => 'Bapak Manager',
            'email' => 'manager@itsm.com',
            'password' => bcrypt('password123'),
            'role' => 'manager',
        ]);

        // 4. IT Head (IT Dept Head) - YANG AKAN APPROVE KEDUA
        User::create([
            'name' => 'Kepala IT',
            'email' => 'headit@itsm.com',
            'password' => bcrypt('password123'),
            'role' => 'it_head',
        ]);
    }
}