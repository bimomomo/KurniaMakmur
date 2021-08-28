<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->uuid('invoicejual_id');
            $table->uuid('pelanggan_id')->nullable();
            $table->date('tgl_sale')->nullable();
            $table->date('jatuh_tempo');
            $table->string('nomor_invoice', 35)->nullable();
            $table->string('faktur_pajak', 50)->nullable();
            $table->string('nomor_po', 50)->nullable();
            $table->string('nomor_surat_jalan', 50)->nullable();
            $table->double('total')->nullable();
            $table->double('diskon')->nullable();
            $table->double('ppn')->nullable();
            $table->double('potongan')->nullable();
            $table->double('biaya_kirim')->nullable();
            $table->string('status_bayar', 12)->nullable();
            $table->string('status_pengiriman', 12)->nullable();
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
        Schema::dropIfExists('sale');
    }
}
