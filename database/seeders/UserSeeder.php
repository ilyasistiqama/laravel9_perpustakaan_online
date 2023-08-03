<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin = User::create([
            'nama' => 'Admin',
            'nik' => 'admin',
            'password' => Hash::make('Admin666'),
            'is_admin' => TRUE 
        ]);

        $admin->assignRole('admin');
    }
}
