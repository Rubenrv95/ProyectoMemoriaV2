<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimensionTieneAprendizajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimension_tiene_aprendizaje', function (Blueprint $table) {
            $table->bigInteger('Dimension');
            $table->bigInteger('Inicial')->nullable();
            $table->bigInteger('Desarrollo')->nullable();
            $table->bigInteger('Logrado')->nullable();
            $table->bigInteger('Especializacion')->nullable();
            $table->bigInteger('refCarrera');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dimension_tiene_aprendizaje');
    }
}
