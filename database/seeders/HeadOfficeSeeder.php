<?php

namespace Database\Seeders;

use App\Models\HeadOffice;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HeadOfficeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        HeadOffice::create([
            'name' => 'PT. BPR Bank Nusamba Balinusra',
            'code' => '01',
            'address' => 'Jl Raya Denpasar - Tabanan, Mengwi, Badung',
            'phone' => '(0361) 812139',
            'email' => 'pusat@bank.com',
        ]);
    }
}
