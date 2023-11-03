<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Plan::create([
            'slug'=>'monthly',
            'price'=> 1000,//10
            'duration_in_days'=> 30,
        ]);
        
        Plan::create([
            'slug'=>'yearly',
            'price'=> 9999,//99.99
            'duration_in_days'=> 365,
        ]);
    }
}