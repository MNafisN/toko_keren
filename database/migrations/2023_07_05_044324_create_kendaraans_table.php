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
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->year('tahun_keluaran');
            $table->string('warna');
            $table->decimal('harga');
            $table->integer('stok');
            $table->integer('terjual');
            $table->string('tipe_kendaraan');
            $table->string('mesin');
            $table->string('suspensi');
            $table->string('transmisi');
            $table->integer('kapasitas_penumpang');
            $table->string('tipe');
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
        Schema::dropIfExists('kendaraans');
    }
};
