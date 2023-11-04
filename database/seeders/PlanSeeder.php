<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Plan;
use Illuminate\Support\Facades\DB;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table('plans')->truncate();

        // Plan::create([
        //     'slug' => 'monthly',
        //     'price' => 9.99,
        //     'duration_in_months' => 1,
        // ]);

        // Plan::create([
        //     'slug' => 'yearly',
        //     'price' => 99.99,
        //     'duration_in_months' => 12,
        // ]);
    }
}
