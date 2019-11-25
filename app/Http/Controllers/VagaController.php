<?php

namespace App\Http\Controllers;

use App\Models\Especialidade;
use App\Models\ModalidadePagamento;
use App\Models\OperadoraUnidade;
use App\Models\TabelaValor;
use App\Models\TipoContratacao;
use App\Models\Vaga;
use App\Models\VagaModalidadePagamento;
use App\Models\VagaTipoContratacao;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class VagaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function listar()
    {

        $vagas = Vaga::select('sala.nome as sala',
            'especialidade.nome as especialidade',
            'operadora_unidade.nome as operadora_unidade',
            //'pessoa_fisica.nome as medico',
            'vaga.*')
            ->join('sala', 'sala.id', 'vaga.idsala')
            ->join('especialidade', 'especialidade.id', 'vaga.idespecialidade')
            ->join('operadora_unidade', 'operadora_unidade.id', 'sala.idoperadora_unidade')
           // ->join('medico', 'medico.id', 'vaga.idmedico')
            //->join('pessoa_fisica', 'pessoa_fisica.idpessoa', 'medico.idpessoa')
            ->get();

        return view('vaga.listar', [
            'vagas' => $vagas
        ]);
    }

    public function cadastrar()
    {

        $unidades = OperadoraUnidade::where(['ativo' => 'A'])->get();
        $especialidades = Especialidade::where(['ativo' => 'A'])->get();
        $modalidadesPag = ModalidadePagamento::where(['ativo' => 'A'])->get();
        $tabelaPrecos = TabelaValor::where(['status' => 'A'])->get();
        $tipoContratacoes = TipoContratacao::where(['ativo' => 'A'])->get();
//        $medicos = Medico::join('pessoa_fisica', 'pessoa_fisica.idpessoa', 'pessoa_fisica.idpessoa')
//                         ->where(['medico.ativo' => 'A'])
//                         ->get();

        return view('vaga.cadastro', [
            'unidades' => $unidades,
            'especialidades' => $especialidades,
//            'medicos' => $medicos,
            'modalidadesPag' => $modalidadesPag,
            'tabelaPrecos' => $tabelaPrecos,
            'tipoContratacoes' => $tipoContratacoes
        ]);
    }

    public function store(Request $request)
    {

        $dados = $request->all();

        DB::beginTransaction();

        $dataInicio = Carbon::createFromFormat('d/m/Y H:i:s', $dados['data_inicio']);
        $dataFim = Carbon::createFromFormat('d/m/Y H:i:s', $dados['data_fim']);
        $dataHoje = Carbon::now();


        $vaga = new Vaga();
        $vaga->idsala = $dados['sala'];
        $vaga->idespecialidade = $dados['especialidade'];
        $vaga->idtabela_valor = $dados['tabela_preco'];
        $vaga->data_inicio = $dataInicio->format('Y-m-d H:i:s');
        $vaga->data_final = $dataFim->format('Y-m-d H:i:s');
        $vaga->data_criacao = $dataHoje->format('Y-m-d');
        $vaga->bonus = $dados['bonus'];
        $vaga->observacao = $dados['observacao'];
        $vaga->visibilidade = $dados['visibilidade'];
        $vaga->ativo = 'A';

        $vaga->idvaga_status = 1;
        $vaga->save();


        foreach ($dados['tipo_contratacao'] as $tipoContratacao) {

            $contratacao = new VagaTipoContratacao();
            $contratacao->idvaga = $vaga->id;
            $contratacao->idtipo_contratacao = $tipoContratacao;
            $contratacao->save();
        }

        foreach ($dados['modalidade_pagamento'] as $pagamento) {

            $modalidadePagamento = new VagaModalidadePagamento();
            $modalidadePagamento->idvaga = $vaga->id;
            $modalidadePagamento->idmodalidade_pagamento = $pagamento;
            $modalidadePagamento->save();
        }

        DB::commit();

        return redirect()->route('vaga.listar');
    }

    public function acompanhamento($idvaga)
    {
        
        $vaga = Vaga::find($idvaga);

        dd($vaga);
        return view('vaga.acompanhamento', [
            'vaga' => $vaga
        ]);
    }
}