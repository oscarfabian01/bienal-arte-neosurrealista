<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'obra';

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id', 'titulo', 'tipo_obra', 'valor_venta'];
}
