<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloTieneSaberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('propuesta_tiene_saber', function (Blueprint $table) {
            $table->unsignedbigInteger('propuesta_modulo');
            $table->unsignedbigInteger('saber');
            $table->foreign('propuesta_modulo')->references('id')->on('propuesta_modulos')->onDelete('cascade');
            $table->foreign('saber')->references('id')->on('sabers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('propuesta_tiene_saber');
    }
}
