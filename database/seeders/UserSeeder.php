<?php

namespace Database\Seeders;

use App\Libraries\Constant;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 3; $i++) {
            User::create([
                'role_id' => Constant::ROLE_ADMIN,
                'name' => "Admin$i",
                'phone' => "123333$i",
                'email' => "admin$i@gmail.com",
                'password' => bcrypt('123456'),
                'verification_code_at' => now(),
                'email_verified_at' => now()
            ]);
        }

        for ($i = 4; $i <= 100; $i++) {
            User::create([
                'role_id' => Constant::ROLE_CLIENT,
                'name' => "User $i",
                'phone' => "333333$i",
                'email' => "user$i@gmail.com",
                'password' => bcrypt('123456'),
                'verification_code_at' => now(),
                'email_verified_at' => now()
            ]);
        }
    }
}
