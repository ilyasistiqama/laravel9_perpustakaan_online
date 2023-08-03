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
        Schema::create('buku', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->string('isbn');
            $table->string('pengarang');
            $table->integer('jumlah_halaman');
            $table->integer('jumlah_stok');
            $table->date('tahun_terbit');
            $table->text('sinopsis');
            $table->string('gambar')->nullable();
            $table->unsignedBigInteger('id_kategori');
            $table->timestamps();
            $table->foreign('id_kategori')
              ->references('id')->on('kategori_buku')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku');
    }
};
