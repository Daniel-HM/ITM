<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtikelStagingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artikel_staging', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->char('ean', 13);
            $table->index('ean');
            $table->string('artikelnr', 50)->nullable()->default('Geen artikelnummer');
            $table->index('artikelnr');
            $table->string('omschrijving', 50)->nullable()->default('Geen omschrijving.');
            $table->index('omschrijving');
            $table->string('vkprijs', 50)->nullable();
            $table->string('inkprijs', 50)->nullable();
            $table->integer('leverancier_id')->unsigned();
            $table->integer('subgroep_id')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('artikel_staging');
    }
}
