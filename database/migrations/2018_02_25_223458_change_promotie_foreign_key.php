<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangePromotieForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('promotie', function (Blueprint $table) {
            $table->dropForeign('promotie_artikelnr_foreign');
        });
        Schema::table('promotie', function (Blueprint $table) {
            $table->foreign('ean')
                ->references('ean')
                ->on('artikel');
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
