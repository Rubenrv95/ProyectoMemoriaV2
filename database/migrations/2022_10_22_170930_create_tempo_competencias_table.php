<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempoCompetenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempo_competencias', function (Blueprint $table) {
            $table->unsignedbigInteger('competencia');
            $table->foreign('competencia')->references('id')->on('competencias')->onDelete('cascade');
            $table->boolean('nivel_1')->nullable();
            $table->boolean('nivel_2')->nullable();
            $table->boolean('nivel_3')->nullable();
            $table->boolean('nivel_4')->nullable();
            $table->boolean('nivel_5')->nullable();
            $table->boolean('nivel_6')->nullable();
            $table->boolean('nivel_7')->nullable();
            $table->boolean('nivel_8')->nullable();
            $table->boolean('nivel_9')->nullable();
            $table->boolean('nivel_10')->nullable();
            $table->boolean('nivel_11')->nullable();
            $table->boolean('nivel_12')->nullable();
            $table->boolean('nivel_13')->nullable();
            $table->boolean('nivel_14')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempo_competencias');
    }
}
