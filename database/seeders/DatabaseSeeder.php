<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\EmployeeModel;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear departamentos ficticios
        $departments = [
            ['name' => 'Recursos Humanos'],
            ['name' => 'Tecnología de la Información'],
            ['name' => 'Marketing'],
            ['name' => 'Finanzas'],
            ['name' => 'Operaciones'],
        ];

        foreach ($departments as $department) {
            DB::table('departments')->insert($department);
        }

        // Crear roles ficticios
        $roles = [
            ['name' => 'Administrador'],
            ['name' => 'Gerente'],
            ['name' => 'Desarrollador'],
            ['name' => 'Analista'],
            ['name' => 'Diseñador'],
        ];

        foreach ($roles as $role) {
            DB::table('roles')->insert($role);
        }

        // Crear empleados ficticios
        for ($i = 0; $i < 20; $i++) {
            DB::table('employees')->insert([
                'name' => fake()->name(),
                'email' => fake()->unique()->safeEmail(),
                'position' => fake()->jobTitle(),
                'salary' => fake()->randomFloat(2, 30000, 120000),
                'hiring_date' => fake()->date(),
                'department_id' => rand(1, count($departments)),
                'role_id' => rand(1, count($roles)),
                'deleted' => 0,
            ]);
        }
    }
}
