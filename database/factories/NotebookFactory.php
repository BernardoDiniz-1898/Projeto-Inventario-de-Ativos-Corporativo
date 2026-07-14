<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class NotebookFactory extends Factory
{
    public function definition(): array
    {
        $marcas = ['Dell', 'Lenovo', 'HP', 'Acer', 'Samsung', 'ASUS'];
        $modelos = [
            'Dell' => ['Latitude 5540', 'Latitude 7440', 'Inspiron 15', 'Vostro 3520'],
            'Lenovo' => ['ThinkPad E14', 'ThinkPad T14', 'IdeaPad 3', 'V14 G3'],
            'HP' => ['ProBook 450 G9', 'EliteBook 840 G9', 'Pavilion 15', '250 G9'],
            'Acer' => ['Aspire 5', 'Swift 3', 'Extensa 15', 'TravelMate P2'],
            'Samsung' => ['Galaxy Book3', 'Galaxy Book4', 'NP750'],
            'ASUS' => ['VivoBook 15', 'ZenBook 14', 'TUF Gaming F15'],
        ];
        $so = ['Windows 10', 'Windows 11', 'Linux Ubuntu', 'macOS'];
        $ram = [4, 8, 16, 32];
        $armazenamento = ['256GB SSD', '512GB SSD', '1TB SSD', '1TB HDD + 256GB SSD'];
        $processadores = ['Intel i5-1235U', 'Intel i7-1355U', 'AMD Ryzen 5 5500U', 'Intel i3-1215U', 'AMD Ryzen 7 5700U'];

        $marca = fake()->randomElement($marcas);
        $modelo = fake()->randomElement($modelos[$marca]);

        return [
            'marca' => $marca,
            'modelo' => $modelo,
            'numero_serie' => strtoupper(fake()->bothify('??#####-####')),
            'patrimonio' => 'PAT-' . fake()->numerify('#####'),
            'status' => fake()->randomElement(['disponivel', 'em_uso', 'manutencao', 'ocioso', 'devolvido', 'obsoleto']),
            'sistema_operacional' => fake()->randomElement($so),
            'ram_gb' => fake()->randomElement($ram),
            'armazenamento' => fake()->randomElement($armazenamento),
            'processador' => fake()->randomElement($processadores),
            'data_aquisicao' => fake()->dateTimeBetween('-3 years', 'now'),
            'data_garantia' => fake()->dateTimeBetween('now', '+2 years'),
            'observacoes' => fake()->optional(0.3)->sentence(),
            'fornecedor' => fake()->optional(0.5)->company(),
            'preco' => fake()->optional(0.7)->randomFloat(2, 1500, 8000),
        ];
    }
}
