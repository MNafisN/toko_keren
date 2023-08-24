<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProdukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $kategori = array('mobil', 'motor');
        $randomKey = array_rand($kategori);

        if ($kategori[$randomKey] == 'mobil') {
            return [
                'produk_id' => 'placeholder',
                'produk_kategori' => $kategori[$randomKey],
                'produk_judul' => fake()->domainWord(),
                'produk_deskripsi' => fake()->text(30),
                'produk_foto' => [],
                'produk_pemasang' => \App\Models\User::raw(function($collection){ return $collection->aggregate([ ['$sample' => ['size' => 1]] ]); })->first()->username,
                'no_telepon' => fake()->phoneNumber(),
                'tampilkan_telepon' => fake()->boolean(),
                'lokasi_provinsi' => fake()->city(),
                'lokasi_kabupaten_kota' => fake()->city(),
                'lokasi_kecamatan' => fake()->city(),
                'lokasi_koordinat' => [],
                'date_posted' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'status' => 'aktif'
            ];    
        } else if ($kategori[$randomKey] == 'motor') {
            return [
                'produk_id' => 'placeholder',
                'produk_kategori' => $kategori[$randomKey],
                'produk_judul' => fake()->domainWord(),
                'produk_deskripsi' => fake()->text(30),
                'produk_foto' => [],
                'produk_pemasang' => \App\Models\User::raw(function($collection){ return $collection->aggregate([ ['$sample' => ['size' => 1]] ]); })->first()->username,
                'no_telepon' => fake()->phoneNumber(),
                'tampilkan_telepon' => fake()->boolean(),
                'lokasi_provinsi' => fake()->city(),
                'lokasi_kabupaten_kota' => fake()->city(),
                'lokasi_kecamatan' => fake()->city(),
                'lokasi_koordinat' => [],
                'date_posted' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'status' => 'aktif'
            ];    
        }
    }

    public function custom(string $id, string $kategori)
    {
        {
            return $this->state([
                'produk_id' => $id,
                'produk_kategori' => $kategori,
                'produk_judul' => fake()->domainWord(),
                'produk_deskripsi' => fake()->text(30),
                'produk_foto' => [],
                'produk_pemasang' => \App\Models\User::raw(function($collection){ return $collection->aggregate([ ['$sample' => ['size' => 1]] ]); })->first()->username,
                'no_telepon' => fake()->phoneNumber(),
                'tampilkan_telepon' => fake()->boolean(),
                'lokasi_provinsi' => fake()->city(),
                'lokasi_kabupaten_kota' => fake()->city(),
                'lokasi_kecamatan' => fake()->city(),
                'lokasi_koordinat' => [],
                'date_posted' => fake()->dateTimeThisMonth()->format('Y-m-d H:i:s'),
                'status' => 'aktif'
            ]);
        }
    }
}
