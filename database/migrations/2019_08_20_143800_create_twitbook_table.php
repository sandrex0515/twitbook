<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTwitbookTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('twitbooks', function (Blueprint $table) {
            
            $table->integer('user_id');
            $table->text('personbook');
            $table->unsignedBigInteger('post_id');
            $table->foreign('post_id')->references('id')->on('users');
            $table->timestamps();
            
        

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('twitbook');
    }
}
