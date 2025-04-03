<?php

namespace Database\Seeders;

use App\Models\Grade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeding primary grades
        for ($i = 1; $i <= 6; $i++) {
            Grade::create([
                'name' => 'Primary ' . $i,
                'stage_id' => 1,
            ]);
        }

        // Seeding preparatory grades
        for ($i = 1; $i <= 3; $i++) {
            Grade::create([
                'name' => 'Preparatory ' . $i,
                'stage_id' => 2,

            ]);
        }
    }
}
