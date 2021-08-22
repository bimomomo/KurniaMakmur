<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBarangsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('barang', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->uuid('kategori_id');
            $table->uuid('brand_id');
            $table->uuid('gudang_id');
            $table->uuid('satuan_id');
            $table->string('nama', 40);
            $table->text('keterangan')->nullable();
            $table->double('terjual')->nullable();
            $table->double('terbeli')->nullable();
            $table->double('sisa')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('barang');
    }
}
