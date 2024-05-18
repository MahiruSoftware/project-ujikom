<?php

namespace Database\Seeders;

use App\Models\Administrator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Administrator::create([
            'username' => 'admin1',
            'password' => Hash::make('hellouniverse1!'),
        ]);
        Administrator::create([
            'username' => 'admin2',
            'password' => Hash::make('hellouniverse2!'),
        ]);
    }
}
