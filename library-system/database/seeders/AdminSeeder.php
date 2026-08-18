<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Buat satu akun admin default untuk login pertama kali.
     *
     * Username: admin
     * Password: admin123
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator Perpustakaan',
                'nis' => null,
                'student_card' => null,
                'password' => Hash::make('admin123'),
                'role' => 'admin',
            ]
        );
    }
}
