<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserlistIngredientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userlists_ingredients', function (Blueprint $table) {
            $table->integer('userlist_id')->unsigned();
            $table->integer('ingredient_id')->unsigned();
            
            $table->foreign('userlist_id')->references('id')->on('userlists');
            $table->foreign('ingredient_id')->references('id')->on('ingredients');
            
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
