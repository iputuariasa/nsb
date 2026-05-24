<?php

namespace Database\Seeders;

use App\Models\Branch;
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
            'name' => 'Kantor Cabang Tegallalang',
            'code' => '03',
            'address' => 'JL. Raya Tegallalang Ubud, Tegallalang, Kec. Gianyar, Kabupaten Gianyar, Bali 80561',
            'phone' => '(0361) 980805',
            'email' => 'tegallalang@bank.com',
        ]);

        Branch::create([
            'head_office_id' => '1',
            'name' => 'Kantor Cabang Bangli',
            'code' => '04',
            'address' => 'Jl. Nusantara No. 06 Bangli',
            'phone' => '(0366) 91856',
            'email' => 'bangli@bank.com',
        ]);
    }
}
