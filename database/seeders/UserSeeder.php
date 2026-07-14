<?php
namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create(['name' => 'Pak Budi (Bos)', 'email' => 'bos@inventaris.local', 'password' => Hash::make('password'), 'role' => 'bos']);
        User::create(['name' => 'Siti (Karyawan)', 'email' => 'karyawan@inventaris.local', 'password' => Hash::make('password'), 'role' => 'karyawan']);
    }
}
