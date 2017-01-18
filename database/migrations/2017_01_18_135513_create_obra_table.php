<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateObraTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creando tabla obra
        Schema::create('obra', function(Blueprint $table){
            $table->increments('id')->comment('ID de la tabla');
            $table->string('titulo')->comment('Titulo de la obra');
            $table->string('sintesis_conceptual')->comment('Sintesis conceptual de la obra');
            $table->string('ruta_fotos_obra')->comment('Ubicación del archivo de las fotos de la obra');
            $table->string('tipo_obra')->comment('Tipo de obra Pintara, Escultura, ETC.');
            $table->integer('alto_medida')->comment('Alto de la obra en cm');
            $table->integer('ancho_medida')->comment('ancho de la obra en cm');
            $table->integer('peso')->comment('Peso de la obra en kg');
            $table->string('tema')->comment('Tema de la obra');
            $table->string('tecnica')->comment('Técnica de la obra');
            $table->double('valor_venta')->comment('Valor de venta de la obra');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Eliminando tabla obra
        Schema::drop('obra');
    }
}
