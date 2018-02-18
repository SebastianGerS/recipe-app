<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserlistablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userlistables', function (Blueprint $table) {
            $table->integer('userlist_id')->unsigned();
            $table->morphs('userlistable');

            $table->foreign('userlist_id')->references('id')->on('userlists');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('userlist_recipes_ingredients');
    }
}
