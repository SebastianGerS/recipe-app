<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserlistRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('userlists_recipes', function (Blueprint $table) {
            $table->integer('userlist_id')->unsigned();
            $table->integer('recipe_id')->unsigned();
            
            $table->foreign('userlist_id')->references('id')->on('userlists');
            $table->foreign('recipe_id')->references('id')->on('recipes');
            
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
