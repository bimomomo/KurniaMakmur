<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengumumanTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('pengumuman', function (Blueprint $table) {
			$table->id();
			$table->uuid('uuid');
			$table->text('pengumuman');
			$table->integer('type')->comment('0=info,1=warning,2=danger')->default(0);
			$table->date('aktif_hingga');
			$table->text('tertuju')->nullable();
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
		Schema::dropIfExists('pengumuman');
	}
}
