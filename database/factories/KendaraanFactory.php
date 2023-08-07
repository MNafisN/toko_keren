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
        if ($strings[$key] == 'mobil') {
            return [
                'produk_id' => \App\Models\Produk::factory()->custom(fake()->unique()->numerify('MBL-#####'), 'mobil')->create()->produk_id,
                'merek' => fake()->company(),
                'model' => fake()->domainWord(),
                'tahun_keluaran' => fake()->year($max = 'now'),
                'jarak_tempuh' => fake()->numerify('#### Km'),
                'warna' => fake()->colorName(),
                'tipe_kendaraan' => $strings[$key],
                'spek_kendaraan' => [
                    'kapasitas_mesin' => fake()->numerify('#### cc'),
                    'kapasitas_penumpang' => fake()->numberBetween($min = 1, $max = 8),
                    'tipe_transmisi' => fake()->randomElement(['automatic', 'manual']),
                    'tipe_bodi' => fake()->citySuffix(),
                    'tipe_bahan_bakar' => fake()->randomElement(['diesel', 'bensin', 'hybrid', 'listrik']),
                    'tipe_penjual' => fake()->randomElement(['individu', 'dealer'])
                ],
                'harga' => fake()->numberBetween($min = 30000000, $max = 1000000000)
            ];
        } else if ($strings[$key] == 'motor') {
            return [
                'produk_id' => \App\Models\Produk::factory()->custom(fake()->unique()->numerify('MTR-#####'), 'motor')->create()->produk_id,
                'merek' => fake()->company(),
                'model' => fake()->domainWord(),
                'tahun_keluaran' => fake()->year($max = 'now'),
                'jarak_tempuh' => fake()->numerify('#### Km'),
                'warna' => fake()->colorName(),
                'tipe_kendaraan' => $strings[$key],
                'spek_kendaraan' => [
                    'kapasitas_mesin' => fake()->numerify('### cc'),
                    'tipe_transmisi' => fake()->randomElement(['automatic', 'manual']),
                    'tipe_penjual' => fake()->randomElement(['individu', 'dealer'])
                ],
                'harga' => fake()->numberBetween($min = 1000000, $max = 50000000),
            ];
        }
    }
}
