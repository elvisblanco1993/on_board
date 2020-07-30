<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrientationUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orientation_user', function (Blueprint $table) {
            $table->unsignedBigInteger('orientation_id');
            $table->unsignedBigInteger('user_id');
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();

            $table->unique(['orientation_id', 'user_id']);

            $table->foreign('orientation_id')->references('id')->on('orientations')->onDelete('cascade');
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
        Schema::dropIfExists('orientation_user');
    }
}
