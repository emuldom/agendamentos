<?php

namespace Database\Factories;

use App\Models\Empresa;
use App\Models\Funcionario;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuario>
 */
class UsuarioFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'empresa_id' => Empresa::factory(),
            'funcionario_id' => Funcionario::factory(),
            'nome_usuario' => fake()->name(),
            'email_login' => fake()->unique()->safeEmail(),
            'senha_hash' => static::$password ??= Hash::make('password'),
            'nivel_acesso' => fake()->randomElement(['Admin', 'Gerente', 'Usuario']),
            'ativo' => true,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Configure the model factory to create a user without an associated employee.
     */
    public function semFuncionario(): static
    {
        return $this->state(fn (array $attributes) => [
            'funcionario_id' => null,
        ]);
    }
}
