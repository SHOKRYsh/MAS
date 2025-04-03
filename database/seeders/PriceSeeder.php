<?php

namespace Database\Seeders;

use App\Models\Price;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PriceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Price::create([
            'subject_id' => 1, //English
            'stage_id' => 1,//primary
            'price' => 80,
        ]);
        Price::create([
            'subject_id' => 1, 
            'stage_id' => 2,
            'price' => 100,
        ]);
        Price::create([
            'subject_id' => 2, 
            'stage_id' => 1,
            'price' => 70,
        ]);
        Price::create([
            'subject_id' => 2, 
            'stage_id' => 2,
            'price' => 90,
        ]);
    }
}
