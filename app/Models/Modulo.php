<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = "modulo";

    public $timestamps = false;

    public function aviso()
    {
        return $this->hasMany('App\Models\Aviso');
    }
}
