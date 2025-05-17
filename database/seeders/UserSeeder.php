<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{





    public function run(): void
    {
        // Admin user
        $admin = [
            "name" => "admin",
            "email" => "admin@taskmonitor.com",
            "username" => "admin",
            "gorev" => "admin",
            "password" => bcrypt("password"),
            "is_admin" => 1,
        ];

        // Normal user
        $user = [
            "name" => "Normal User",
            "email" => "user@taskmonitor.com",
            "username" => "fawuqifaby",
            "gorev" => "developer",
            "password" => bcrypt("password"),
            "is_admin" => 0,
        ];

        User::create($admin);
        User::create($user);



    }
}
