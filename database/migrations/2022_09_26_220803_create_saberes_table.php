<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaberesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sabers', function (Blueprint $table) {
            $table->id();
            $table->longText('descripcion_saber');
            $table->string('tipo');
            $table->string('nivel')->nullable();
            $table->unsignedbigInteger('refaprendizaje');
            $table->foreign('refaprendizaje')->references('id')->on('aprendizajes')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('saberes');
    }
}
