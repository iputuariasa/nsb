<?php

namespace Database\Seeders;

use App\Models\Pillar;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PillarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Pillar::create([
            'name' => 'Existing'
        ]);

        Pillar::create([
            'name' => 'Cross Selling'
        ]);

        Pillar::create([
            'name' => 'Lunas'
        ]);

        Pillar::create([
            'name' => 'CNL'
        ]);

        Pillar::create([
            'name' => 'Back To Back'
        ]);

        Pillar::create([
            'name' => 'Take Over Slik'
        ]);

        Pillar::create([
            'name' => 'Premium'
        ]);

        Pillar::create([
            'name' => 'Back To Back Plus'
        ]);

        Pillar::create([
            'name' => 'Baru'
        ]);
    }
}
