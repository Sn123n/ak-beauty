<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $user = User::create([
            "role_id" => "1",
            'name' => 'Admin', 
            'email' => 'admin@gmail.com',
            'password' => bcrypt('12345678')
        ]);
    }
}
