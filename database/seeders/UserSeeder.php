<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        \App\Models\Users::create([
            'firstName' => 'Admin',
            'lastName' => 'User',
            'email' => 'admin@gmail.com',
            'mobile' => '01700000000',
            'password' => \Illuminate\Support\Facades\Hash::make('12345678'),
            'otp' => '0'
        ]);
    }
}
