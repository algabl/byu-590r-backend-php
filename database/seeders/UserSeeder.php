<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "name" => "alexblack",
                "email" => "alexandergblack@outlook.com",
                "email_verified_at" => null,
                "password" => bcrypt("password"),
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
            ],
        ];
        User::insert($users);
    }
}
