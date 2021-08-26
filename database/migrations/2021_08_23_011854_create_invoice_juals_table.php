<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoiceJualsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoice_jual', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid');
            $table->uuid('barang_id');
            $table->uuid('satuan_id');
            $table->uuid('gudang_id');
            $table->double('harga');
            $table->double('harga_akhir');
            $table->double('total_satuan_jual');
            $table->double('jumlah_satuan_dijual');
            $table->double('jumlah_satuan_isi');
            $table->string('satuan_jual', 11);
            $table->integer('status')->default('0');
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
        Schema::dropIfExists('invoice_jual');
    }
}
