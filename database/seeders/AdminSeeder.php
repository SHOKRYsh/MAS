<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::create([
            'name' => 'MAS',
            'email' => 'mas@Gmail.com',
            'phone' => '01119189472',
            'password' => Hash::make('MAS@MAS'),
        ]);

        Admin::create([
            'name' => 'Asmaa Fayed',
            'email' => 'asmaa@Gmail.com',
            'phone' => '01128461333',
            'password' => Hash::make('ASMAA@ASMAA123'),
        ]);
    }
}
