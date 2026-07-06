<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // CHANGE THESE CREDENTIALS before going live.
        User::firstOrCreate(
            ['mobile' => '03000000000'],
            [
                'name'     => 'Super Admin',
                'email'    => 'admin@shopbookish.com',
                'role'     => 'super_admin',
                'password' => 'password',   // hashed by the cast
            ]
        );
    }
}
