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
            $table->string('Nombre_modulo');
            $table->Integer('Semestre');
            $table->string('Tipo');
            $table->Integer('Creditos');
            $table->Integer('Horas_semanales');
            $table->Integer('Horas_totales');
            $table->boolean('Clases')->nullable();
            $table->boolean('Seminario')->nullable();
            $table->boolean('Actividades_practicas')->nullable();
            $table->boolean('Talleres')->nullable();
            $table->boolean('Laboratorios')->nullable();
            $table->boolean('Actividades_clinicas')->nullable();
            $table->boolean('Actividades_terreno')->nullable();
            $table->boolean('Ayudantias')->nullable();
            $table->boolean('Tareas')->nullable();
            $table->boolean('Estudios')->nullable();
            $table->bigInteger('refPropuesta');
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
