<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAprendizajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aprendizajes', function (Blueprint $table) {
            $table->id();
            $table->longText('Descripcion_aprendizaje');
            $table->string('Nivel')->nullable();
            $table->string('Nivel_aprend');
            $table->bigInteger('refDimension');
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
        Schema::dropIfExists('aprendizajes');
    }
}
