<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEanColumnToPromotiesAndPromotiesStaging extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotie', function (Blueprint $table) {
            $table->char('ean',13);
        });
        Schema::table('promotie_staging', function (Blueprint $table) {
            $table->string('ean');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
