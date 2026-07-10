<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class;

    public function definition(): array
    {
        $departamentos = ['TI', 'Financeiro', 'RH', 'Marketing', 'Vendas', 'Operações', 'Administrativo', 'Jurídico', 'Comercial'];
        $cargos = [
            'TI' => ['Analista de TI', 'Desenvolvedor', 'Suporte Técnico', 'Gerente de TI'],
            'Financeiro' => ['Analista Financeiro', 'Contador', 'Gerente Financeiro'],
            'RH' => ['Analista de RH', 'Recrutador', 'Gerente de RH'],
            'Marketing' => ['Analista de Marketing', 'Designer', 'Gerente de Marketing'],
            'Vendas' => ['Consultor de Vendas', 'Gerente Comercial', 'Executivo de Vendas'],
            'Operações' => ['Analista de Operações', 'Coordenador', 'Gerente de Operações'],
            'Administrativo' => ['Assistente Administrativo', 'Coordenador', 'Gerente Administrativo'],
            'Jurídico' => ['Advogado', 'Assessor Jurídico', 'Gerente Jurídico'],
            'Comercial' => ['Analista Comercial', 'Gerente Comercial'],
        ];

        $departamento = fake()->randomElement($departamentos);

        return [
            'nome' => fake()->name(),
            'matricula' => 'MAT-' . fake()->numerify('#####'),
            'email' => fake()->unique()->safeEmail(),
            'telefone' => fake()->numerify('(##) #####-####'),
            'departamento' => $departamento,
            'centro_custo' => fake()->optional(0.6)->bothify('CC-???-###'),
            'projeto' => fake()->optional(0.4)->randomElement(['Migração Cloud', 'Projeto Alpha', 'Digitalização', 'Expansão SP', 'Modernização', null]),
            'setor' => fake()->optional(0.7)->words(2, true),
            'cargo' => fake()->randomElement($cargos[$departamento] ?? ['Analista']),
            'status' => fake()->randomElement(['ativo', 'afastado', 'desligado', 'ferias']),
            'data_admissao' => fake()->dateTimeBetween('-5 years', 'now'),
            'observacoes' => fake()->optional(0.3)->sentence(),
        ];
    }
}
