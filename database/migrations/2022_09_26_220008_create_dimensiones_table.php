<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDimensionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimensions', function (Blueprint $table) {
            $table->id();
            $table->longText('descripcion_dimension');
            $table->integer('orden');
            $table->unsignedbigInteger('refcompetencia');
            $table->foreign('refcompetencia')->references('id')->on('competencias')->onDelete('cascade');
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
        Schema::dropIfExists('dimensiones');
    }
}
