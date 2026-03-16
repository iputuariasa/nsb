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
            'head_office_id' => '1',
            'branch_code' => '4100',
            'name' => 'Kantor Pusat Operasional Tegallalang',
            'phone_number' => '(0361) 980805',
            'address' => 'JL. Raya Tegallalang Ubud, Tegallalang, Kec. Gianyar, Kabupaten Gianyar, Bali 80561'
        ]);

        Branch::create([
            'head_office_id' => '1',
            'branch_code' => '4101',
            'name' => 'Kantor SKK Kredit Gianyar',
            'phone_number' => ' (0361) 948910',
            'address' => 'Jl. Patih Jelantik, Gianyar'
        ]);
    }
}
