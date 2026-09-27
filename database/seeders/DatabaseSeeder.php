<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database with 100% authentic production data.
     */
    public function run(): void
    {
        $this->call([
            SovereignProductionSeeder::class,
        ]);
    }
}
