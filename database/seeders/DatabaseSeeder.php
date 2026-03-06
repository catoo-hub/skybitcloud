<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'admin@skybit.cloud'],
            [
                'name' => 'Admin',
                'password' => 'admin12345',
                'is_admin' => true,
            ]
        );

        User::query()->firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => 'password',
                'is_admin' => false,
            ]
        );

        Product::query()->firstOrCreate(
            ['slug' => 'start'],
            [
                'name' => 'Start',
                'description' => 'Для лендингов и MVP',
                'price' => 490,
                'cpu' => 2,
                'ram_gb' => 2,
                'disk_gb' => 40,
                'is_active' => true,
            ]
        );

        Product::query()->firstOrCreate(
            ['slug' => 'pro'],
            [
                'name' => 'Pro',
                'description' => 'Для продакшн-проектов',
                'price' => 1490,
                'cpu' => 4,
                'ram_gb' => 8,
                'disk_gb' => 120,
                'is_active' => true,
            ]
        );

        Product::query()->firstOrCreate(
            ['slug' => 'business'],
            [
                'name' => 'Business',
                'description' => 'Для высоких нагрузок',
                'price' => 3990,
                'cpu' => 8,
                'ram_gb' => 16,
                'disk_gb' => 300,
                'is_active' => true,
            ]
        );
    }
}
