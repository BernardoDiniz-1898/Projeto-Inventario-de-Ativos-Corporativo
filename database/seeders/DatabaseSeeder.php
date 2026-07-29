<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Notebook;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::create([
            'name' => 'Admin Local',
            'email' => 'admin@local.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);
    }
}
