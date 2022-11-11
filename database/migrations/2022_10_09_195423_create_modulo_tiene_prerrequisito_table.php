<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModuloTienePrerrequisitoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modulo_tiene_prerrequisito', function (Blueprint $table) {
            $table->unsignedbigInteger('modulo');
            $table->unsignedbigInteger('prerrequisito');
            $table->foreign('modulo')->references('id')->on('modulos')->onDelete('cascade');
            $table->foreign('prerrequisito')->references('id')->on('modulos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('modulo_tiene_prerrequisito');
    }
}
