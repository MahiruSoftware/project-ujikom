<?php

namespace Database\Seeders;

use App\Models\Player;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Player::create([
            'username' => 'player1',
            'password'=> Hash::make('helloworld1!'),
        ]);
        Player::create([
            'username' => 'player2',
            'password'=> Hash::make('helloworld2!'),
        ]);
    }
}
