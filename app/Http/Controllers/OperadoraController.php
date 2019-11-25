<?php

namespace App\Http\Controllers;

use App\Models\Bairro;
use App\Models\Contato;
use App\Models\Endereco;
use App\Models\Operadora;
use App\Models\Pessoa;
use App\Models\PessoaJuridica;
use App\Models\TipoContato;
use App\Models\TipoEndereco;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Cidade;
use App\Models\Vaga;
use App\Models\TabelaValor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class OperadoraController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {

        $vagas = [];

        $paises = Pais::get();
        $operadora = new Operadora();
        return view('operadora.cadastro',[
            'paises' => $paises,
            'operadora' => $operadora,
            'vagas' => $vagas
        ]);
    }

    public function store(Request $request, ImageRepository $image)
    {

        $dadosPost = $request->post();

        DB::beginTransaction();

        $pessoa = new Pessoa();
        $pessoa->tipo = 'PJ';
        $pessoa->ativo = 'A';

        if(!$pessoa->save()){

            DB::rollBack();
            return false;
        }

        $pessoaJuridica = new PessoaJuridica();
        $pessoaJuridica->idpessoa = $pessoa->id;
        $pessoaJuridica->nome_fantasia =$dadosPost['nome_fantasia'];
        $pessoaJuridica->razao_social = $dadosPost['razao_social'];

        $pessoaJuridica->cnpj = $dadosPost['cnpj'];
        $pessoaJuridica->cnae = $dadosPost['cnae'];

        if(!$pessoaJuridica->save()){

            DB::rollBack();
            return '1';
        }

        $contatoEmail = new Contato();
        $contatoEmail->idpessoa = $pessoa->id;
        $contatoEmail->idtipo_contato = TipoContato::where(['tipo' => 'EMAIL'])->first()->id;
        $contatoEmail->contato = $dadosPost['email'];

        if(!$contatoEmail->save()){

            DB::rollBack();
            return '2';
        }

        $contatoTelefone = new Contato();
        $contatoTelefone->idpessoa = $pessoa->id;
        $contatoTelefone->idtipo_contato = TipoContato::where(['tipo' => 'TELEFONE'])->first()->id;
        $contatoTelefone->contato = $dadosPost['telefone'];


        if(!$contatoTelefone->save()){

            DB::rollBack();
            return '3';
        }

        $operadora = new Operadora();
        $operadora->idpessoa = $pessoa->id;
        $operadora->email = $dadosPost['email'];
        $operadora->website = $dadosPost['website'];
        $operadora->ativo = isset($dadosPost['ativo']) ? 'A' : 'I';

        if ($request->hasFile('logotipo')) {

            $operadora->logotipo = $image->saveImage($request->logotipo);
        }

        if(!$operadora->save()){

            DB::rollBack();
            return false;
        }

        $endereco = new Endereco();
        $endereco->idpessoa = $pessoa->id;
        $endereco->idbairro = $dadosPost['bairro'];
        $endereco->idtipo_endereco = TipoEndereco::where(['tipo' => 'OPERADORA'])->first()->id;
        $endereco->ativo = 'A';
        $endereco->principal = 'S';
        $endereco->logradouro = $dadosPost['endereco'];
        $endereco->cep = $dadosPost['cep'];
        $endereco->save();

        DB::commit();

        return redirect()->route('operadora.listar');
    }

    public function listar(Request $request)
    {

        $filtro = $request->input('filtro', '');


        if($request->input('chkBanco')){
            if($request->input('acao') == 'Ativar'){

                foreach($request->input('chkBanco') as $id){
                    $this->ativar($id);
                }
            }else if($request->input('acao') == 'Inativar'){

                foreach($request->input('chkBanco') as $id){
                    $this->inativar($id);
                }
            }else{

                foreach($request->input('chkBanco') as $id){

                    $this->remover($id);
                }
            }
        }

        $operadoras = Operadora::select('contato.*','pessoa_juridica.*', 'operadora.*')
                              ->join('contato', 'operadora.idpessoa', 'contato.idpessoa')
                              ->join('tipo_contato', 'contato.idtipo_contato', 'tipo_contato.id')
                              ->join('pessoa_juridica', 'operadora.idpessoa', 'pessoa_juridica.idpessoa')
                              ->where(function($query){
                                 $query->where(['tipo_contato.tipo' => 'TELEFONE']);
                                 $query->where('operadora.ativo', '<>', 'E');
                             })
                              ->when($filtro, function($query) use ($filtro) { 

                                  if($filtro == 'Ativo'){

                                    $filtro = 'A';
                                  }else if($filtro == 'Inativo'){

                                    $filtro = 'I';
                                  }

                                $query->where(function($query) use ($filtro){

                                    $query->where('pessoa_juridica.cnpj', 'like', '%' . $filtro . '%');
                                    $query->orWhere('pessoa_juridica.nome_fantasia', 'like', '%' . $filtro . '%');
                                    $query->orWhere('pessoa_juridica.razao_social', 'like', '%' . $filtro . '%');
                                    $query->orWhere('operadora.ativo', '=', $filtro);
                                });
                                
                              })
                              ->get();

        if (Auth::user()->hasAcesso("Operadora")) {
            
            return view('operadora.listar',[
                'operadoras' => $operadoras,
                'filtro' => $filtro
            ]);

        } else {
            return redirect('/home')
                    ->with('error', 'Você não tem permissão para acessar a tela de Operadora!');
        }
    }

    public function storeAlterar($id, Request $request, ImageRepository $image )
    {

        $dadosPost = $request->post();

        DB::beginTransaction();

        $operadora = Operadora::find($id);

        Operadora::where(['id' => $id])
                ->update([
                    'email' => $dadosPost['email'],
                    'website' => $dadosPost['website'],
                    'ativo' => isset($dadosPost['ativo']) ? 'A' : 'I',
                    'logotipo' => $request->hasFile('logotipo') ? $image->saveImage($request->logotipo) : $operadora->logotipo,
                    ]);

        $operadora = Operadora::find($id);

        $pessoaJuridica = PessoaJuridica::where(['idpessoa' => $operadora->idpessoa])
                                        ->update([
                                            'nome_fantasia' => $dadosPost['nome_fantasia'],
                                            'razao_social' => $dadosPost['razao_social'],
                                            'cnpj' => $dadosPost['cnpj'],
                                            'cnae' => $dadosPost['cnae']
                                        ]);

        $contatoEmail = Contato::where(['idtipo_contato' => TipoContato::where(['tipo' => 'EMAIL'])->first()->id])
                            ->where(['idpessoa' => $operadora->idpessoa])
                            ->update(['contato' => $dadosPost['email']]);



        $contatoTelefone = Contato::where(['idtipo_contato' => TipoContato::where(['tipo' => 'TELEFONE'])->first()->id])
                                ->where(['idpessoa' => $operadora->idpessoa])
                                ->update(['contato' => $dadosPost['telefone']]);


        $endereco = Endereco::where(['idpessoa' => $operadora->idpessoa])
                            ->update([
                                'idbairro' => $dadosPost['bairro'],
                                'logradouro' => $dadosPost['endereco'],
                                'cep' => $dadosPost['cep']
                            ]);
        DB::commit();

        return redirect()->route('operadora.listar');
    }

    public function alterar($id)
    {
        
        $paises = Pais::get();

        $operadora = Operadora::select(['pessoa.*',
                                        'endereco.*',
                                        'bairro.*',
                                        'cidade.*',
                                        'estado.*',
                                        'pessoa_juridica.*',
                                        'contato.*',
                                        'tipo_contato.*',
                                        'operadora.*'])
                        ->join('pessoa', 'pessoa.id' , 'operadora.idpessoa')
                        ->join('endereco', 'endereco.idpessoa' , 'pessoa.id')
                        ->join('bairro', 'bairro.id' , 'endereco.idbairro')
                        ->join('cidade', 'cidade.id' , 'bairro.idcidade')
                        ->join('estado', 'estado.id' , 'cidade.idestado')
                        ->join('pessoa_juridica', 'pessoa_juridica.idpessoa', 'operadora.idpessoa')
                        ->join('contato', 'operadora.idpessoa', 'contato.idpessoa')
                        ->join('tipo_contato', 'contato.idtipo_contato', 'tipo_contato.id')
            ->where(['operadora.id' => $id])
            ->where(['tipo_contato.tipo' => 'TELEFONE'])
            ->first();

        $vagas = Vaga::select('sala.nome as sala',
            'especialidade.nome as especialidade',
            'operadora_unidade.nome as operadora_unidade',
            //'pessoa_fisica.nome as medico',
            'vaga.*')
            ->join('sala', 'sala.id', 'vaga.idsala')
            ->join('especialidade', 'especialidade.id', 'vaga.idespecialidade')
            ->join('operadora_unidade', 'operadora_unidade.id', 'sala.idoperadora_unidade')
            ->join('operadora', 'operadora.id', 'operadora_unidade.idoperadora')
            // ->join('medico', 'medico.id', 'vaga.idmedico')
            //->join('pessoa_fisica', 'pessoa_fisica.idpessoa', 'medico.idpessoa')
            ->where(['operadora.id' => $id])
            ->get();

        return view('operadora.cadastro',[
            'operadora' => $operadora,
            'paises' => $paises,
            'cidades' => json_encode(Cidade::where(['idestado' => $operadora->idestado])->get()),
            'estados' => json_encode(Estado::where(['idpais' => $operadora->idpais])->get()),
            'bairros' => json_encode(Bairro::where(['idcidade' => $operadora->idcidade])->get()),
            'vagas' => $vagas,
            'include' => true
        ]);
    }

    private function remover($id)
    {

        $operadora = Operadora::find($id);
        $operadora->ativo = 'E';
        $operadora->save();
    }

    private function inativar($id)
    {

        $operadora = Operadora::find($id);
        $operadora->ativo = 'I';
        $operadora->save();
    }

    private function ativar($id)
    {

        $operadora = Operadora::find($id);
        $operadora->ativo = 'A';
        $operadora->save();
    }

    public function buscarTabelaPorUnidade($id)
    {

        return response()->json([
            'vagas' =>
            TabelaValor::where([
                'status' => 'A'
            ])->where([
                'idoperadora_unidade' => $id
            ])->get()
        ]);
    }
}
