<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class BuatTabelBerita extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('berita', function (Blueprint $table) {
            $table->increments('id');

            $table->uuid('uuid');
            $table->string('foto');
            $table->string('sumber_foto')->nullable();

            $table->string('judul');
            $table->string('slug')->unique();

            $table->string('preview');
            $table->longText('isi');
            $table->string('sumber')->nullable();
            
            $table->integer('komentar')->default(0);
            $table->integer('headline')->default(0);
            $table->integer('view')->default(0);
            $table->integer('status')->default(1);

            $table->integer('id_operator')->nullable();
            $table->integer('id_kategori')->nullable();

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
        Schema::dropIfExists('berita');
    }
}
