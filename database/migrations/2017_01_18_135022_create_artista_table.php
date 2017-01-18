<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateArtistaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //Creando tabla artista
        Schema::create('artista', function(Blueprint $table){
            $table->increments('id')->comment('ID de la tabla');
            $table->string('nombre')->comment('Nombres del artista');
            $table->string('apellido')->comment('Apellidos de artista');
            $table->integer('pais_id')->comment('Pais del artista');
            $table->date('fecha_nacimiento')->comment('Fecha de nacimiento del artista');
            $table->string('direccion_postal')->comment('Dirección postal del artista');
            $table->string('email')->comment('Dirección de correo electronico');
            $table->string('telefono_movil')->comment('Número del teléfono movil');
            $table->string('perfil_artista')->comment('Perfil del artista');
            $table->string('ruta_hoja_vida')->comment('Ubicación del archivo de hoja de vida');
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
        //Eliminando tabla artista
        Schema::drop('artista');
    }
}
