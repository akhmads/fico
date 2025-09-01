<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(UserSeeder::class);
        $this->call(PpnSeeder::class);
        $this->call(PphSeeder::class);
        $this->call(CurrencySeeder::class);
        $this->call(UomSeeder::class);
        $this->call(CoaSeeder::class);
        $this->call(ItemSeeder::class);
    }
}
