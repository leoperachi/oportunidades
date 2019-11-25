<?php

namespace App\Http\Controllers;

use App\Models\Bairro;
use App\Models\Contato;
use App\Models\Endereco;
use App\Models\Pessoa;
use App\Models\Operadora;
use App\Models\Perfil;
use App\Models\OperadoraUnidade;
use App\Models\OperadoraUnidadeFoto;
use App\Models\TipoContato;
use App\Models\TipoEndereco;
use App\Repositories\ImageRepository;
use Illuminate\Http\Request;
use App\Models\Pais;
use App\Models\Estado;
use App\Models\Cidade;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UnidadeRequest;


class UnidadeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $paises = Pais::get();
        $unidade = new OperadoraUnidade();

        return view('unidade.cadastro',[
            'paises' => $paises,
            'unidade' => $unidade
        ]);
    }

    public function store(UnidadeRequest $request, ImageRepository $image)
    {
        $dadosPost = $request->post();
        // dd($dadosPost['cidade']);
        DB::beginTransaction();
        
        $telefone = preg_replace("/[^0-9]/", "", $request->telefone);

        $unidade = new OperadoraUnidade();
        $unidade->nome = $dadosPost['nome'];
        $unidade->telefone = $telefone;
        $unidade->endereco = $dadosPost['endereco'];
        $unidade->latitude = $dadosPost['latitude'];
        $unidade->longitude = $dadosPost['longitude'];
        $unidade->idoperadora = 1;
        $unidade->ativo = isset($dadosPost['ativo']) ? 'A' : 'I';
        $unidade->bairro = $dadosPost['bairro'];
        $unidade->cidade = $dadosPost['cidade'];
        $unidade->UF = $dadosPost['uf'];
        $unidade->pais = $dadosPost['pais'];
        $unidade->cep = $dadosPost['cep'];
        
        if(!$unidade->save()){
            DB::rollBack();
            return false;
        }

        if($request->foto){

            $unidadeFoto = new OperadoraUnidadeFoto();

            $i = 1;

            foreach($request->foto as $imagem){
                foreach($request->legenda as $legenda){
                    $unidadeFoto->legenda = $legenda;
                    $unidadeFoto->arquivo = $imagem;
                    $unidadeFoto->ordem = $i;
                    $unidadeFoto->ativo = isset($dadosPost['ativo']) ? 'A' : 'I';
                    $unidadeFoto->idoperadora_unidade = $unidade->id;         
                }
                $i++;
            }

            if(!$unidadeFoto->save()){
                DB::rollBack();
                return false;
            }
        }

        DB::commit();
        return redirect()->route('unidade.listar');
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

        $unidades = OperadoraUnidade::select('nome','telefone','cidade.cidade as cidade','estado.estado as estado','ordem as fotos','operadora_unidade.ativo as status','operadora_unidade.id AS id')
        ->join('cidade','cidade.id','operadora_unidade.cidade')
        ->join('estado','estado.id','operadora_unidade.UF')
        ->join('operadora_unidade_foto','idoperadora_unidade','operadora_unidade.id')
        ->where(function($query){
           $query->where('operadora_unidade.ativo', '<>', 'E');
       })
        ->when($filtro, function($query) use ($filtro) { 

            if($filtro == 'Ativo'){

              $filtro = 'A';
            }else if($filtro == 'Inativo'){

              $filtro = 'I';
            }

          $query->where(function($query) use ($filtro){

              $query->where('operadora_unidade.nome', 'like', '%' . $filtro . '%');
              $query->orWhere('telefone', 'like', '%' . $filtro . '%');
              $query->orWhere('cidade.cidade', 'like', '%' . $filtro . '%');
              $query->orWhere('estado.estado', 'like', '%' . $filtro . '%');
              $query->orWhere('operadora_unidade.ativo', '=', $filtro);
          });  
        })->orderBy('ordem')->get();

        // dd($unidades);

        return view('unidade.listar',[
            'unidades' => $unidades,
            'filtro' => $filtro
        ]);
    }

    public function storeAlterar($id, UnidadeRequest $request, ImageRepository $image )
    {
        $dadosPost = $request->post();
        $telefone = preg_replace("/[^0-9]/", "", $request->telefone);
        
        DB::beginTransaction();

        $unidade = OperadoraUnidade::find($id);

        OperadoraUnidade::where(['id' => $id])
                ->update([
                    'nome' => $dadosPost['nome'],
                    'telefone' => $telefone,
                    'ativo' => isset($dadosPost['ativo']) ? 'A' : 'I',
                    'latitude' => $dadosPost['latitude'],
                    'longitude' => $dadosPost['longitude'],
                    'endereco' => $dadosPost['endereco'],
                    'cep' => $dadosPost['cep'],
                    'bairro' => $dadosPost['bairro'],
                    'cidade' => $dadosPost['cidade'],
                    // 'logotipo' => $request->hasFile('logotipo') ? $image->saveImage($request->logotipo) : $operador->logotipo,
                    'pais' => $dadosPost['pais']  
                    ]);

        DB::commit();

        return redirect()->route('unidade.listar');
    }

    public function alterar($id)
    {
        $paises = Pais::get();

        $unidade = OperadoraUnidade::select(['*'])
            ->where(['id' => $id])
            ->first();

        return view('unidade.cadastro',[
            'unidade' => $unidade,
            'paises' => $paises,
            'cidades' => json_encode(Cidade::where(['idestado' => $unidade->idestado])->get()),
            'estados' => json_encode(Estado::where(['idpais' => $unidade->idpais])->get()),
            'bairros' => json_encode(Bairro::where(['idcidade' => $unidade->idcidade])->get()),
        ]);
    }

    private function remover($id)
    {

        $unidade = OperadoraUnidade::find($id);
        $unidade->ativo = 'E';
        $unidade->save();
    }

    private function inativar($id)
    {

        $unidade = OperadoraUnidade::find($id);
        $unidade->ativo = 'I';
        $unidade->save();
    }

    private function ativar($id)
    {

        $unidade = OperadoraUnidade::find($id);
        $unidade->ativo = 'A';
        $unidade->save();
    }
}
