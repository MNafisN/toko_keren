<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjualan>
 */
class PenjualanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'nama_kendaraan' => fake()->firstNameMale(),
            'nama_pembeli' => fake()->name(),
            'jumlah_beli' => fake()->numberBetween($min = 1, $max = 10),
        ];
    }
}
