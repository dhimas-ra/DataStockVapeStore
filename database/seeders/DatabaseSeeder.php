<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Stock;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create(
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'phone' => '08989282912',
                'address' => 'Bojong Gede',
                'remember_token' => Str::random(10),
                'is_admin' => true
            ]
        );
        \App\Models\User::factory()->create(
            [
                'name' => 'Dhimas Rizqi Akbar',
                'email' => 'dhimas@mail.com',
                'email_verified_at' => now(),
                // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'phone' => '08789282912',
                'address' => 'Perumnas',
                'remember_token' => Str::random(10),
                'is_admin' => false
            ]
        );

        User::factory(10)->create();
        Category::factory(5)->create();
        Stock::factory(100)->create();
    }
}
