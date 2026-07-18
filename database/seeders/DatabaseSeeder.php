<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // CategorySeeder::class,
            SchoolSeeder::class,
            SettingSeeder::class,
            AdminSeeder::class,
            GiftsAndDecorSeeder::class,
            ProductsSeeder::class,
        ]);
    }
}
