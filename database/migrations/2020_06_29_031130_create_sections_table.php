<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
            $table->longText('body')->nullable();
            $table->string('provider')->nullable();
            $table->string('video')->nullable();
            $table->timestamps();
        });

        /**
         * Section types
         */
        Schema::create('types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('label')->nullable();
            $table->timestamps();
        });

        /**
         * Pivot table to join sections with types of sections
         */
        Schema::create('section_type', function (Blueprint $table) {
            $table->unsignedBigInteger('section_id');
            $table->unsignedBigInteger('type_id');
            $table->timestamps();
            $table->unique(['section_id', 'type_id']);

            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
            $table->foreign('type_id')->references('id')->on('types')->onDelete('cascade');
        });

        /**
         * Pivot table to join Orientations with Sections
         */
        Schema::create('orientation_section', function (Blueprint $table) {
            $table->unsignedBigInteger('orientation_id');
            $table->unsignedBigInteger('section_id');
            $table->timestamps();
            $table->unique(['orientation_id', 'section_id']);

            $table->foreign('orientation_id')->references('id')->on('orientations')->onDelete('cascade');
            $table->foreign('section_id')->references('id')->on('sections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sections');
    }
}
