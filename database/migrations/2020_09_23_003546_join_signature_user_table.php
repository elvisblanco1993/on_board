<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class JoinSignatureUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signature_user', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('signature_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('signature_id')->references('id')->on('signatures')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signature_user');
    }
}
