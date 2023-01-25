<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNonAlcoholicColumnIntoCocktailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cocktails', function (Blueprint $table) {
            $table->string('non_alcoholic');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cocktails', function (Blueprint $table) {
            $table->dropColumn('non_alcoholic');
        });
    }
}
