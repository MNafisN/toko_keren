<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kendaraan>
 */
class KendaraanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $strings = array(
            'mobil',
            'motor',
        );
        $key = array_rand($strings);
        if ($strings[$key] == 'motor') {
            return [
                'tahun_keluaran' => fake()->year($max = 'now'),
                'warna' => fake()->colorName(),
                'harga' => fake()->numberBetween($min = 1000000, $max = 1000000000),
                'stok' => fake()->numberBetween($min = 1000, $max = 10000),
                'terjual' => fake()->numberBetween($min = 20, $max = 500),
                'tipe_kendaraan' => $strings[$key],
                'mesin' => fake()->domainWord(),
                'tipe_suspensi' => fake()->company(),
                'tipe_transmisi' => fake()->citySuffix(),
            ];
        } else {
            return [
                'tahun_keluaran' => fake()->year($max = 'now'),
                'warna' => fake()->colorName(),
                'harga' => fake()->numberBetween($min = 1000000, $max = 1000000000),
                'stok' => fake()->numberBetween($min = 1000, $max = 10000),
                'terjual' => fake()->numberBetween($min = 20, $max = 500),
                'tipe_kendaraan' => $strings[$key],
                'mesin' => fake()->domainWord(),
                'kapasitas_penumpang' => fake()->numberBetween($min = 1, $max = 8),
                'tipe' => fake()->citySuffix(),
            ];
        }
    }
}
