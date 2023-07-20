<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PassportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $oauthData = [
            [
                'id' => 1,
                'name' => 'Personal Access Client',
                'secret' => 'Q18ErXf5JhsoSBtqjseP1PghC4DkcstgX6pUmkrC',
                'provider' => null,
                'redirect' => 'http://localhost',
                'personal_access_client' => 1,
                'password_client' => 0,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'id' => 2,
                'name' => 'Password Grant Client',
                'secret' => 'KyUQay9gWj5OmE1VOeqFzbBRk3mEVvKmARWEYJ31',
                'provider' => 'users',
                'redirect' => 'http://localhost',
                'personal_access_client' => 0,
                'password_client' => 1,
                'revoked' => 0,
                'created_at' => now(),
                'updated_at' => now()
            ]
        ];

        DB::table('oauth_clients')->insert($oauthData);
    }
}
