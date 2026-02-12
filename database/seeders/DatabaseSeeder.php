<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'المدير',
            'email' => 'admin@jelaba.ma',
            'password' => Hash::make('password'),
        ]);

        // Seed products
        $this->call(ProductSeeder::class);
    }
}
