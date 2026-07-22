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
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::create([
            'name' => 'Admin Local',
            'email' => 'admin@local.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
        ]);

        $employees = Employee::factory(15)->create();

        Notebook::factory(20)->create([
            'funcionario_id' => null,
        ]);

        $notebooks = Notebook::all()->random(12);
        foreach ($notebooks as $notebook) {
            $notebook->update([
                'funcionario_id' => $employees->random()->id,
                'status' => 'em_uso',
            ]);
        }
    }
}
