<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $datas = [
            [
            'first_name' => 'Johny',
            'last_name' => 'Bairstow',
            'user_name' => 'johny226',
            'email' => 'johny@vfs.com',
            'role' => 'admin',
            'current_role' => 'admin',
            'password' => Hash::make(12345678),
            ],
            [
            'first_name' => 'Mitchell',
            'last_name' =>'Marsh',
            'user_name' => 'marsh226',
            'email' => 'marsh@vfx.com',
            'role' => 'admin',
            'current_role' => 'admin',
            'password' => Hash::make(12345678),
            ],
        ];

        User::insert($datas);
    }
}
