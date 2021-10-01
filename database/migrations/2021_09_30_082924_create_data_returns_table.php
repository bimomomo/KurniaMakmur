<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_returns', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->double('biaya_kirim');
            $table->double('diskon');
            $table->uuid('driver_id');
            $table->bigInteger('faktur_pajak');
            $table->date('jatuh_tempo');
            $table->bigInteger('nomor_invoice');
            $table->bigInteger('nomor_po');
            $table->bigInteger('nomor_surat_jalan');
            $table->uuid('pelanggan_id');
            $table->double('ppn');
            $table->date('tgl_sale');
            $table->double('total');
            $table->uuid('uuidSale');
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
        Schema::dropIfExists('data_returns');
    }
}
