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
            $table->longText('descripcion_aprendizaje');
            $table->string('nivel_aprend');
            $table->unsignedbigInteger('refdimension');
            $table->foreign('refdimension')->references('id')->on('dimensions')->onDelete('cascade');
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
