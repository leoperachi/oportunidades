<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{

    protected $table = 'sala';

    public $timestamps = false;


    public function unidade()
    {

        return $this->belongsTo(OperadoraUnidade::class, 'idoperadora_unidade');
    }
}