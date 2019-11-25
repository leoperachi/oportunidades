<?php


namespace App\Http\Controllers;

use App\Models\Sala;

class SalaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function buscarPorUnidade($id)
    {

        return response()->json([
            'salas' => Sala::where(['idoperadora_unidade' => $id])->orderBy('nome')->get()
        ]);
    }
}