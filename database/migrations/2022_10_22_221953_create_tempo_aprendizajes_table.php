<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTempoAprendizajesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tempo_aprendizajes', function (Blueprint $table) {
            $table->id('aprendizaje');
            $table->boolean('1')->nullable();
            $table->boolean('2')->nullable();
            $table->boolean('3')->nullable();
            $table->boolean('4')->nullable();
            $table->boolean('5')->nullable();
            $table->boolean('6')->nullable();
            $table->boolean('7')->nullable();
            $table->boolean('8')->nullable();
            $table->boolean('9')->nullable();
            $table->boolean('10')->nullable();
            $table->boolean('11')->nullable();
            $table->boolean('12')->nullable();
            $table->boolean('13')->nullable();
            $table->boolean('14')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tempo_aprendizajes');
    }
}
