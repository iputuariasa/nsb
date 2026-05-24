<?php

namespace Database\Seeders;

use App\Models\Kiosk;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KioskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Kiosk::create([
            'branch_id' => '1',
            'name' => 'Kantor SKK Kredit Gianyar',
            'code' => '0101',
            'address' => 'Jl. Patih Jelantik, Gianyar',
            'phone' => '(0361) 948910',
            'email' => 'kiosk.tegallalang1@bank.com',
        ]);
    }
}
