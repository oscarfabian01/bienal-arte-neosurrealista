<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Artista extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'artista';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'apellido', 'pais_id', 'fecha_nacimiento', 'direccion_postal', 'email', 'telefono_movil', 'perfil_artista', 'ruta_hoja_vida'];
}
