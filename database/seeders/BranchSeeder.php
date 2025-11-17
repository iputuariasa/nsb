<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Branch::create([
            'central_code' => '4',
            'branch_code' => '4100',
            'central_name' => 'PT. BPR Nusamba Tegallalang',
            'branch_name' => 'Kantor Pusat Operasional Tegallalang',
        ]);

        Branch::create([
            'central_code' => '4',
            'branch_code' => '4101',
            'central_name' => 'PT. BPR Nusamba Tegallalang',
            'branch_name' => 'Kantor SKK Kredit Gianyar',
        ]);
    }
}
