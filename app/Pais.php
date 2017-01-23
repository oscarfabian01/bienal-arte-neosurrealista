<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pais extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pais';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['codigo', 'pais'];
}
