<?php

namespace Database\Seeders;

use App\Models\Stage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Stage::create([
            'name' => 'Primary',
        ]);
        Stage::create([
            'name' => 'Preparatory',
        ]);
    }
}
