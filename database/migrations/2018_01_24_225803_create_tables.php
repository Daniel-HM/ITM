<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create('leverancier', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');

            $table->integer('leverancier_id')->unsigned();
            $table->unique('leverancier_id');

            $table->string('naam', 45);
        });

        Schema::create('groep', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');

            $table->integer('groep_id')->unsigned();
            $table->unique('groep_id');

            $table->string('omschrijving', 45);
        });

        Schema::create('subgroep', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->integer('groep_id')->unsigned();

            $table->integer('subgroep_id')->unsigned();
            $table->unique('subgroep_id');

            $table->string('omschrijving', 45);
        });

        Schema::create('artikel', function (Blueprint $table) {
            $table->engine = "InnoDB";
            $table->increments('id');
            $table->char('ean', 13);
            $table->index('ean');
            $table->string('artikelnr', 50);
            $table->index('artikelnr');
            $table->string('omschrijving', 50)->nullable()->default('Geen omschrijving.');
            $table->index('omschrijving');
            $table->decimal('vkprijs', 10);
            $table->decimal('inkprijs', 10);
            $table->integer('leverancier_id')->unsigned();
            $table->integer('subgroep_id')->unsigned();
        });
        Schema::table('artikel', function (Blueprint $table) {
            $table->foreign('leverancier_id')
                ->references('leverancier_id')
                ->on('leverancier');

            $table->foreign('subgroep_id')
                ->references('subgroep_id')
                ->on('subgroep');
        });

        Schema::table('subgroep', function (Blueprint $table) {
            $table->foreign('groep_id')
                ->references('groep_id')
                ->on('groep');

        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('groep');
        Schema::drop('subgroep');
        Schema::drop('leverancier');
        Schema::drop('artikel');
    }

}
