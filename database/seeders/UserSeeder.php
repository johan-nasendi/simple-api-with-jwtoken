<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users =[
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@demo.id',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ],
            [
                'name' => 'Johan',
                'email' => 'user@demo.id',
                'email_verified_at' => now(),
                'password' => bcrypt('password'),
            ],
        ];
       
        User::insert($users);
        
    }
}
