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
        User::create([
            'id' => 1,
            'role_id' => Constant::ROLE_ADMIN,
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('123456'),
            'verification_code_at' => now(),
            'email_verified_at' => now()
        ]);
    }
}
