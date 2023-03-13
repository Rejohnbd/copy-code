<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'first_name'    => 'Sahed',
            'last_name'     => 'Ahmed',
            'email'         => 'admin@mail.com',
            'password'      => Hash::make('password'),
            'user_type'     => 'admin',
        ]);
    }
}
