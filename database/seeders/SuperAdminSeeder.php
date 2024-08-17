<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "id_num" => "000",
            "firstname" => "Super",
            "lastname" => "Admin",
            "password" => Hash::make("password"),
            "is_active" => true,
            "activate_at" => now(),
            "level" => "superadmin",
        ]);
    }
}
