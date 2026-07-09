<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'maixuanloc0101@gmail.com'],
            ['name' => 'Xuan Loc', 'password' => Hash::make('meo-admin-2026')]
        );

        $this->call(PortfolioSeeder::class);
    }
}
