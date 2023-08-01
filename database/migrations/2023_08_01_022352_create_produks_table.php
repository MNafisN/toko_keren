<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('produk_id')->unique();
            $table->string('produk_kategori');
            $table->string('produk_judul');
            $table->text('produk_deskripsi');
            $table->produk_foto();
            $table->string('produk_pemasang');
            $table->kontak_pemasang();
            $table->string('lokasi_provinsi');
            $table->string('lokasi_kabupaten_kota');
            $table->string('lokasi_kecamatan');
            $table->lokasi_koordinat();
            $table->timestamp('date_posted');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produks');
    }
};
