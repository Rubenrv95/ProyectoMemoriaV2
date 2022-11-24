<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropuestaTieneSaberTable extends Migration
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
            $table->foreign('propuesta_modulo')->references('id')->on('propuesta_modulos')->onUpdate('cascade')->onDelete('cascade');
            $table->id('saber');
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
