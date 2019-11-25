<?php

namespace App\Http\Controllers;

Use App\Models\ComunicacaoTipo;
Use App\Models\Comunicacao;
Use App\Models\Prospect;
use Illuminate\Http\Request;

class ComunicacaoController extends Controller
{
    public function cadastro()
    {
        $tipo = ComunicacaoTipo::all();
        return view('doctorservice.comunicacao.cadastro')
            ->with('tipo', $tipo);
    }

    public function cadastrar(Request $request)
    {
        $this->validate($request, [
            'tipo' => 'required'
        ]);
        $prospectCadastrado = Prospect::latest('id')->first();
        $comunicacao = new Comunicacao();
        $comunicacao->mensagem = $request->mensagem;
        $comunicacao->data = $request->data;
        $comunicacao->ativo = $request->ativo;
        $comunicacao->idcomunicacao_tipo = $request->tipo;
        $comunicacao->idprospect = $prospectCadastrado->id;
        $comunicacao->save();
        return redirect("prospect/{$prospectCadastrado->id}");
    }
}
