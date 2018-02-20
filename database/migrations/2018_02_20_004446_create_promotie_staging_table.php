<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotieStagingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('promotie_staging', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('naam', 255);
            $table->string('omschrijving', 255);
            $table->string('artikelnr', 255);
            $table->string('startdatum');
            $table->string('einddatum');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('promotie_staging');
    }
}
