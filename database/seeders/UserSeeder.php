<?php

namespace Database\Seeders;

use illuminate\Support\Facades\Hash;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'nama' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin'),
                'role' => 'admin',
            ],
            [
                'nama' => 'Dokter',
                'email' => 'dokter@gmail.com',
                'passowrd' => Hash::make('dokter'),
                'role' => 'dokter',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
