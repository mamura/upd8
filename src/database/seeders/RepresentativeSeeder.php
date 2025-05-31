<?php

namespace Database\Seeders;

use App\Models\Representative;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RepresentativeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rep1 = Representative::create(['name' => 'João Silva']);
        $rep2 = Representative::create(['name' => 'Raimundo Nonato']);
        $rep3 = Representative::create(['name' => 'Cristiano Ronaldo']);

        $rep1->cities()->attach([1, 2, 3]);
        $rep2->cities()->attach([1, 4]);
        $rep3->cities()->attach([2, 3, 4, 5]);
    }
}
