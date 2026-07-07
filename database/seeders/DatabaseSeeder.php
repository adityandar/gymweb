<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            PlanSeeder::class,
        ]);

        $admin = User::factory()->create([
            'name' => 'Admin GymFlow',
            'email' => 'admin@gymflow.test',
            'password' => 'password',
        ]);
        $admin->assignRole('admin');

        $trainer = User::factory()->create([
            'name' => 'Trainer Satu',
            'email' => 'trainer@gymflow.test',
            'password' => 'password',
        ]);
        $trainer->assignRole('trainer');

        $member = User::factory()->create([
            'name' => 'Member Satu',
            'email' => 'member@gymflow.test',
            'password' => 'password',
        ]);
        $member->assignRole('member');
    }
}
