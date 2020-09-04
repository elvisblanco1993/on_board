<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCertificatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('status')->nullable();
            $table->string('paper_orientation')->default('landscape');

            $table->string('body_bg')->nullable();
            $table->string('cert_bg')->nullable();

            $table->string('cert_border_out_color')->nullable();
            $table->string('cert_border_out_radius')->nullable();
            $table->string('cert_border_out_thickness')->nullable();
            $table->string('cert_border_out_style')->nullable();

            $table->string('cert_border_in_color')->nullable();
            $table->string('cert_border_in_radius')->nullable();
            $table->string('cert_border_in_thickness')->nullable();
            $table->string('cert_border_in_style')->nullable();

            $table->string('cert_text_color')->default('#000000');
            $table->string('footer_text_color')->default('#000000');
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
        Schema::dropIfExists('certificates');
    }
}
