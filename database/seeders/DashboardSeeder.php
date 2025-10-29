<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DashboardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (User::count() < 10) {
            // Create admin user
            User::firstOrCreate([
                'email' => 'admin@gmail.com'
            ], [
                'name' => 'Admin User',
                'password' => Hash::make('22222222'),
                'email_verified_at' => now(),
            ]);

            // Create some random users
            User::factory(15)->create();

            $dates = [
                now()->subDays(6),
                now()->subDays(5),
                now()->subDays(4),
                now()->subDays(3),
                now()->subDays(2),
                now()->subDays(1),
                now(),
            ];

            foreach ($dates as $date) {
                User::factory(rand(1, 5))->create([
                    'created_at' => $date,
                    'updated_at' => $date,
                ]);
            }
        }
    }
}
