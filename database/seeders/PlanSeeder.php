<?php

namespace Database\Seeders;

use App\Models\MembershipPlan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        MembershipPlan::create([
            'name' => 'Basic',
            'duration_months' => 1,
            'price' => 300000,
            'description' => 'Akses gym selama 1 bulan penuh. Cocok untuk pemula.',
            'is_active' => true,
        ]);

        MembershipPlan::create([
            'name' => 'Premium',
            'duration_months' => 3,
            'price' => 750000,
            'description' => 'Hemat dengan paket 3 bulan. Akses penuh semua fasilitas.',
            'is_active' => true,
        ]);

        MembershipPlan::create([
            'name' => 'Annual',
            'duration_months' => 12,
            'price' => 2500000,
            'description' => 'Paket tahunan dengan harga terbaik. Bebas akses setahun penuh.',
            'is_active' => true,
        ]);
    }
}
