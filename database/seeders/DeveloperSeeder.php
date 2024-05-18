<?php

namespace Database\Seeders;

use App\Models\Developer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DeveloperSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Developer::create([
            'username' => 'dev1',
            'password' => Hash::make('hellobyte1!'),
        ]);
        Developer::create([
            'username' => 'dev2',
            'password' => Hash::make('hellobyte2!'),
        ]);
    }
}
