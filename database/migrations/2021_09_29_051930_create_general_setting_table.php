<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralSettingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_setting', function (Blueprint $table) {
            $table->id();
			$table->uuid('uuid');
			$table->text('logo')->nullable();
			$table->string('nama');
			$table->string('nama_pendek');
			$table->text('alamat')->nullable();
			$table->string('no_telp')->nullable();
			$table->text('tag_line')->nullable();
			$table->text('signature')->nullable();
			$table->integer('active')->default(0);
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
        Schema::dropIfExists('general_setting');
    }
}
