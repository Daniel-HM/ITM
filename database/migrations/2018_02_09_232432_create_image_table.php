<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImageTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::disableForeignKeyConstraints();
        Schema::create('image', function (Blueprint $table) {
            $table->increments('id');
            $table->char('ean', 13);
            $table->index('ean');
            $table->string('name', 255);
            $table->integer('leverancier_id')->unsigned();
        });
        Schema::table('image', function (Blueprint $table) {
            $table->foreign('ean')
                ->references('ean')
                ->on('artikel');
        });
        Schema::table('image', function (Blueprint $table) {
            $table->foreign('leverancier_id')
                ->references('leverancier_id')
                ->on('leverancier');
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
        Schema::dropIfExists('image');
    }
}
