<?php

namespace Database\Seeders;

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
        \App\Models\User::factory()->create([
            'name' => 'Control de Tráfico',
            'email' => 'tc@trax.com',
            'password' => bcrypt('1234'),
            'role' => 'traffic_control'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Operador 1',
            'email' => 'op1@trax.com',
            'password' => bcrypt('1234'),
            'role' => 'operator'
        ]);
    }
}
