<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePromotie extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('promotie', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->string('naam', 255);
            $table->string('omschrijving', 255);
            $table->string('artikelnr', 50);
            $table->date('startdatum');
            $table->date('einddatum');
        });

        Schema::table('promotie', function (Blueprint $table) {
            $table->foreign('artikelnr')
                ->references('artikelnr')
                ->on('artikel');
        });
        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('promotie');
    }
}
