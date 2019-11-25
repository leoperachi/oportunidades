<?php

namespace App\Http\Controllers;

use App\Models\Bairro;
use App\Models\Contato;
use App\Models\Endereco;
use App\Models\Operador;
use App\Models\Pessoa;
use App\Models\Operadora;
use App\Models\Perfil;
use App\Models\OperadoraUnidade;
use App\Models\PessoaFisica;
use App\Models\Users;
use App\Models\EstadoCivil;
use App\Models\Nacionalidade;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Cidade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\OperadorRequest;
use Illuminate\Support\Facades\Storage;


class OperadorController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        // $perfis = Perfil::where(['perfil.ativo' => 'A'])->get();
        //modulo referente a operadora
        $perfis = Perfil::where(function($query){
            $query->where('perfil.ativo', '<>', 'E');
            $query->Where('perfil.idmodulo','=',2);
        })->get();

        $pessoas = PessoaFisica::join('pessoa', 'pessoa.id', 'pessoa_fisica.idpessoa')->where(function($query){
            $query->where('pessoa_fisica.ativo', '=', 'A');
            $query->where('pessoa.tipo','=','PF');
        })->get();
        // dd($pessoas);
        $unidades = OperadoraUnidade::where(['ativo' => 'A'])->get();

        $operadoras = Operadora::join('pessoa_juridica','pessoa_juridica.idpessoa','operadora.idpessoa')->where('operadora.ativo', '=', 'A')->select('operadora.id AS id','razao_social AS nome')->get();
        // dd($operadoras);
        $operador = new Operador();
        return view('operador.cadastro',[
            'operador' => $operador,
            'unidades' => $unidades,
            'perfis' => $perfis,
            'pessoas' => $pessoas,
            'operadoras' => $operadoras
        ]);
    }

    public function upload(Request $request, ImageRepository $image){

        $file = $request->file('foto');

        if($request->hasFile('foto')){
            return $image->saveImage($request->foto);
        }
    }

    public function store(OperadorRequest $request, ImageRepository $image)
    {
        $dadosPost = $request->post();

        $telefone = preg_replace("/[^0-9]/", "", $request->telefone);
        $celular = preg_replace("/[^0-9]/", "", $request->celular);
        $cpf = preg_replace("/[^0-9]/", "", $request->cpf);

        DB::beginTransaction();
        $operador = new Operador();
        $user = new Users;

        if($request->hasFile('foto')){
            $user->foto = $image->saveImage($request->foto); 
        }
            
        $operador->telefone1 = $telefone;
        $operador->telefone2 = $celular;
        $operador->ramal1 = $dadosPost['ramal'];
        $operador->idoperadora = $dadosPost['operadora'];
        $operador->ativo = isset($dadosPost['status']) ? 'A' : 'I';

        $user->idperfil = $dadosPost['perfil'];
        $user->name = $dadosPost['nome']; 
        $user->email = $dadosPost['email'];
        $user->password = Hash::make($dadosPost['senha']);
        $user->ativo = isset($dadosPost['status']) ? 'A' : 'I';
        $user->apelido = $dadosPost['apelido'];

        $pessoa = new Pessoa();
        $pessoa->ativo = isset($dadosPost['status']) ? 'A' : 'I';
        $pessoa->tipo = 'PF';

        if(!$pessoa->save()){
            DB::rollBack();
            return false;
        }

        $operador->idpessoa = $pessoa->id;

        $estadoCivil = new EstadoCivil();
        $estadoCivil->ativo = 'A';
        $estadoCivil->estado = 'solteiro';
        
        if(!$estadoCivil->save()){
            DB::rollBack();
            return false;
        }

        $nacionalidade = new Nacionalidade();
        $nacionalidade->ativo = 'A';
        $nacionalidade->nacionalidade = 'brasil';
        
        if(!$nacionalidade->save()){
            DB::rollBack();
            return false;
        }
        $pessoa = PessoaFisica::where(['cpf' => $cpf])->first();
        // dd($pessoa);
        if($pessoa){
            PessoaFisica::where(['cpf' => $cpf])
                    ->update([
                        'nome' => $dadosPost['nome'],
                        'sexo' => $dadosPost['sexo'],
                        'data_nascimento' => $dadosPost['dataNascimento'],
                        'ativo' => isset($dadosPost['status']) ? 'A' : 'I'
                        ]);
            $operador->idpessoa = $pessoa->idpessoa;
        }else{
            $pessoaFisica = new PessoaFisica();
            $pessoaFisica->idpessoa = $pessoa->id;
            $pessoaFisica->nome = $dadosPost['nome'];
            $pessoaFisica->ativo = isset($dadosPost['status']) ? 'A' : 'I';
            $pessoaFisica->cpf = $cpf;
            $pessoaFisica->sexo = $dadosPost['sexo'];
            $pessoaFisica->idestado_civil = $estadoCivil->id;
            $pessoaFisica->idnacionalidade = $nacionalidade->id;
            $pessoaFisica->data_nascimento = date('Y-m-d',strtotime($dadosPost['dataNascimento']));
            
            if(!$pessoaFisica->save()){
                DB::rollBack();
                return false;
            }
        }
        
        if(!$user->save()){
            DB::rollBack();
            return false;
        }
        $operador->user_id = $user->id;

        if(!$operador->save()){
            DB::rollBack();
            return false;
        }

        DB::commit();

        return redirect()->route('operador.listar');
    }

    public function listar(Request $request)
    {
        // dd($request->input());
        $filtro = $request->input('filtro','');
          
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

        if($request->input('operadora') || $request->input('unidade') || $request->input('perfil') || $request->input('status')){

            $operadora = $request->input('operadora');
            $unidade = $request->input('unidade');
            $perfil = $request->input('perfil');
            $status = $request->input('status');

            $operadores = Operador::select('cpf','pessoa_fisica.nome AS nome','pessoa_juridica.razao_social AS operadora','operadora_unidade.nome AS unidade','perfil.nome AS perfil','operadora.id AS idoperadora','operador.id AS id','operador.ativo AS status')
                              ->join('operadora', 'operador.idoperadora', 'operadora.id')
                              ->join('users', 'operador.user_id', 'users.id')
                              ->join('pessoa_fisica','operador.idpessoa', 'pessoa_fisica.idpessoa')
                              ->join('perfil', 'users.idperfil', 'perfil.id')
                              ->join('pessoa_juridica','operadora.idpessoa','pessoa_juridica.idpessoa')
                              ->join('operadora_unidade', 'operadora.id', 'operadora_unidade.idoperadora')
                            ->when($operadora, function ($query) use ($operadora) {
                                return $query->where('operadora.id', $operadora);

                            })->when($unidade, function ($query) use ($unidade) {
                                return $query->where('operadora_unidade.id', $unidade);

                            })->when($perfil, function ($query) use ($perfil) {
                                return $query->where('perfil.id', $perfil);
                            })
                            ->when($status,function ($query) use ($status) {
                                return $query->where('operador.ativo', $status);
                            })
                            ->get();

            // dd($operadores);
        }else{
            $operadores = Operador::select('cpf','pessoa_fisica.nome AS nome','pessoa_juridica.razao_social AS operadora','operadora_unidade.nome AS unidade','perfil.nome AS perfil','operadora.id AS idoperadora','operador.id AS id','operador.ativo AS status')
                                ->join('operadora', 'operador.idoperadora', 'operadora.id')
                                //   ->join('pessoa', 'operador.idpessoa', 'pessoa.id')
                                ->join('users', 'operador.user_id', 'users.id')
                                ->join('pessoa_fisica','operador.idpessoa', 'pessoa_fisica.idpessoa')
                                ->join('perfil', 'users.idperfil', 'perfil.id')
                                ->join('pessoa_juridica','operadora.idpessoa','pessoa_juridica.idpessoa')
                                ->join('operadora_unidade', 'operadora.id', 'operadora_unidade.idoperadora')
                                //   ->join('operadora_grupo', 'operadora.id', 'operadora_grupo.idoperadora')
                                ->where(function($query){
                                    $query->where('operador.ativo', '<>', 'E');
                                })
                                ->when($filtro, function($query) use ($filtro) { 

                                    if($filtro == 'Ativo'){
                                        $filtro = 'A';
                                    }else if($filtro == 'Inativo'){
                                        $filtro = 'I';
                                    }
                                    $query->where(function($query) use ($filtro){

                                        $query->where('pessoa_fisica.cpf', 'like', '%' . $filtro . '%');
                                        $query->orWhere('users.name', 'like', '%' . $filtro . '%');
                                        $query->orWhere('razao_social', 'like', '%' . $filtro . '%');
                                        // $query->orWhere('operadora.nome', 'like', '%' . $filtro . '%');
                                        $query->orWhere('operadora_unidade.nome', 'like', '%' . $filtro . '%');
                                        $query->orWhere('perfil.nome', 'like', '%' . $filtro . '%');
                                        $query->orWhere('operador.ativo', '=', $filtro);
                                        $query->orWhere('cpf', '=', $filtro);
                                    });
                                })->get();
        }
            // dd($operadores);
        $perfis = Perfil::where(function($query){
            $query->where('perfil.ativo', '<>', 'E');
            $query->Where('perfil.idmodulo','=',2);
        })->get();

        $operadoras = Operadora::join('pessoa_juridica','pessoa_juridica.idpessoa','operadora.idpessoa')->where('operadora.ativo', '=', 'A')->select('operadora.id AS id','razao_social AS nome')->get();

        $unidades = OperadoraUnidade::where(['ativo' => 'A'])->get();

        return view('operador.listar',[
            'operadores' => $operadores,
            'filtro' => $filtro,
            'perfis' => $perfis,
            'operadoras' => $operadoras,
            'unidades' => $unidades
        ]);
    }

    public function storeAlterar($id, OperadorRequest $request, ImageRepository $image )
    {

        $dadosPost = $request->post();

        $telefone = preg_replace("/[^0-9]/", "", $request->telefone);
        $celular = preg_replace("/[^0-9]/", "", $request->celular);
        $cpf = preg_replace("/[^0-9]/", "", $request->cpf);

        DB::beginTransaction();

        $operador = Operador::find($id);
        // dd($request);
        Operador::where(['id' => $id])
                    ->update([
                        'telefone1' => $telefone,
                        'telefone2' => $celular,
                        'ramal1' => $dadosPost['ramal'],
                        'idoperadora' => $dadosPost['operadora'],
                        'ativo' => isset($dadosPost['status']) ? 'A' : 'I'
                        ]);

        // $operador = Operador::find($id);

        $pessoaFisica = pessoaFisica::where(['idpessoa' => $operador->idpessoa])
                                        ->update([
                                            'nome' => $dadosPost['nome'],
                                            'cpf' => $cpf,
                                            'sexo' => $dadosPost['sexo'],
                                            'data_nascimento' => $dadosPost['dataNascimento'],
                                            'ativo' => isset($dadosPost['status']) ? 'A' : 'I'
                                        ]);

        $user = Users::where(['id' => $operador->user_id ])
                            ->update([
                                'idperfil' => $dadosPost['perfil'],
                                'name' => $dadosPost['nome'],
                                'email' => $dadosPost['email'],
                                'password' => Hash::make($dadosPost['senha']),
                                'apelido' => $dadosPost['apelido'],
                                'ativo' => isset($dadosPost['status']) ? 'A' : 'I'
                            ]);

        // $endereco = Endereco::where(['idpessoa' => $operador->idpessoa])
        //                     ->update([
        //                         'idbairro' => $dadosPost['bairro'],
        //                         'logradouro' => $dadosPost['endereco'],
        //                         'cep' => $dadosPost['cep']
        //                     ]);
        DB::commit();

        return redirect()->route('operador.listar');
    }

    public function alterar($id)
    {

        // $operador = Operador::select('cpf','name','operadora_unidade.nome','perfil.nome','users.status','operador.id','data_nascimento AS dataNascimento','sexo','apelido','users.email')
        //                       ->join('operadora', 'operador.idoperadora', 'operadora.id')
        //                       ->join('pessoa', 'operador.idpessoa', 'pessoa.id')
        //                       ->join('pessoa_fisica','pessoa.id', 'pessoa_fisica.idpessoa')
        //                       ->join('users', 'operador.user_id', 'users.id')
        //                       ->join('perfil', 'users.idperfil', 'perfil.id')
        //                       ->join('operadora_unidade', 'operadora.id', 'operadora_unidade.idoperadora')
        //                     //   ->join('operadora_grupo', 'operadora.id', 'operadora_grupo.idoperadora')
        //                 ->where(['operador.id' => $id])
        //                 // ->where(['operadora.ativo' => ''])
        //                 ->first();
        
        $operador = Operador::select('cpf',
                                    'pessoa_fisica.nome AS nome',
                                    'pessoa_juridica.razao_social AS operadora',
                                    'operadora.id AS idoperadora',
                                    'operadora_unidade.nome AS unidade',
                                    'perfil.nome AS perfil',
                                    'perfil.id AS idperfil',
                                    'operador.id AS id',
                                    'operador.ativo AS status',
                                    'pessoa_fisica.sexo AS sexo',
                                    'pessoa_fisica.data_nascimento AS dataNascimento',
                                    'users.apelido AS apelido',
                                    'operador.telefone1 AS telefone',
                                    'operador.ramal1 AS ramal',
                                    'operador.telefone2 AS celular' 
                                    )
                              ->join('operadora', 'operador.idoperadora', 'operadora.id')
                            //   ->join('pessoa', 'operador.idpessoa', 'pessoa.id')
                              ->join('users', 'operador.user_id', 'users.id')
                              ->join('pessoa_fisica','operador.idpessoa', 'pessoa_fisica.idpessoa')
                              ->join('perfil', 'users.idperfil', 'perfil.id')
                              ->join('pessoa_juridica','operadora.idpessoa','pessoa_juridica.idpessoa')
                              ->join('operadora_unidade', 'operadora.id', 'operadora_unidade.idoperadora')

                              ->where(['operador.id' => $id])->first();

        // $perfis = Perfil::where(['perfil.ativo' => 'A'])->get();
        // $pessoas = Pessoa::join('pessoa_fisica', 'pessoa_fisica.idpessoa', 'pessoa.id')->where(['pessoa.tipo' => 'PF'])->get();
        // $unidades = OperadoraUnidade::where(['ativo' => 'A'])->get();
        // $operadoras = Operadora::join('operadora_grupo', 'operadora_grupo.idoperadora', 'operadora.id')->where(['operadora_grupo.ativo' => 'A'])->get();
        
        // dd($operador);

        return view('operador.cadastro',[
            'operador' => $operador
        ]);
    }

    private function remover($id)
    {

        $operador = Operador::find($id);
        $operador->ativo = 'E';
        $operador->save();
    }

    private function inativar($id)
    {

        $operador = Operador::find($id);
        $operador->ativo = 'I';
        $operador->save();
    }

    private function ativar($id)
    {

        $operador = Operador::find($id);
        $operador->ativo = 'A';
        $operador->save();
    }
}
