<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulos', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->Integer('creditos');
            $table->Integer('horas_semanales');
            $table->Integer('horas_totales');
            $table->boolean('clases')->nullable();
            $table->boolean('seminario')->nullable();
            $table->boolean('actividades_practicas')->nullable();
            $table->boolean('talleres')->nullable();
            $table->boolean('laboratorios')->nullable();
            $table->boolean('actividades_clinicas')->nullable();
            $table->boolean('actividades_terreno')->nullable();
            $table->boolean('ayudantias')->nullable();
            $table->boolean('tareas')->nullable();
            $table->boolean('estudios')->nullable();
            $table->unsignedbigInteger('refpropuesta');
            $table->foreign('refpropuesta')->references('id')->on('propuesta_modulos')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamp('created_at')->nullable('false')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->nullable()->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulos');
    }
}
