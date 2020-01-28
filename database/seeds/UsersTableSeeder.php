<?php

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => User::ADMIN_NAME,
            'email' => 'admin@blog.com',
            'password' => Hash::make('admin'),
            'role' => User::ROLE_ADMIN
        ]);
        User::create([
            'name' => 'Blog User',
            'email' => 'user@blog.com',
            'password' => Hash::make('user'),
            'role' => User::ROLE_USER
        ]);
    }
}
