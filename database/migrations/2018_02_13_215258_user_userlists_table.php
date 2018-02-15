<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserUserlistsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_userlists', function (Blueprint $table) {
            $table->integer('user_id')->unsigned();
            $table->integer('userlist_id')->unsigned();

            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('user_userlists');
    }
}
