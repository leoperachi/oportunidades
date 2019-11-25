<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Models\MedicoDisponibilidade;
use App\Models\Medico;
use App\Models\Oportunidade;
use App\Models\Especialidade;
use App\Models\OportunidadeCliente;
use App\Models\OportunidadeStatusBD;
use App\Models\OportunidadeTipo;

class MedicoDisponibilidadeController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //Fazer validação se usuário possui permissão de acesso
        //?????????

        //Busca informações para campos de filtros
        $status = $this->getStatus();
        $especialidades = $this->getEspecialidades();
        
        //Busca informaões referente a disponibilidade dos médicos
        $medicoDisponibilidade = $this->queryMedicoDispinibilidade()->get();
        //dd($medicoDisponibilidade);
        
        $openFiltroAvancado = Session::get('openFiltroAvancado');
        Session::remove('openFiltroAvancado');
        $filtroObject = $this->montaFiltro(Session::get('filtroObject'));
        Session::remove('filtroObject');

        $filtroObject->idoportunidade_tipo = null;
        if(!isset($openFiltroAvancado)) 
        {
            $openFiltroAvancado = false;
        }
        
        return view('disponibilidade/consultaDisponibilidadeMedicos', 
                    ["medicoDisponibilidade" => $medicoDisponibilidade, 
                     "especialidades" => $especialidades, 
                     "status" => $status, 
                     "filtroObject" => $filtroObject,
                     "openFiltroAvancado" => $openFiltroAvancado]
                    );
    }

    public function consultar(Request $request) 
    {
        $acao = $request->get('acao');
        $successMsg = null;
        $openFiltroAvancado = false;
        
        if(isset($acao)){
            if($request->get('acao') == 'priorizar'){
                $idStr = '';
                foreach($request->input('chkOportunidade') as $id){
                    $this->priorizar($id);
                    $idStr = $idStr . $id . ',';
                }
                $successMsg = 'Oportunidades ' . substr($idStr, 0, -1) . ' priorizadas';
            }
        }
        $filtroObject = new \stdClass();
        $oportunidades = $this->queryOportunidades();

        $id = $request->input('codigo');

        if(isset($id)){
            $openFiltroAvancado = true;
            $filtroObject->codigo = $id;
            $oportunidades = $oportunidades->where('oportunidade.id', '=', $id);            
        }
        else{
            $filtroObject->codigo = '';
        }

        $idoportunidade_tipos = $request->input('chkTipoOportunidade');
        if(isset($idoportunidade_tipos)){
            foreach($idoportunidade_tipos as $idoportunidade_tipo){
                $openFiltroAvancado = true;
                $oportunidades = $oportunidades->where('oportunidade.idoportunidade_tipo', '=', $idoportunidade_tipo);
                $filtroObject->idoportunidade_tipo = $idoportunidade_tipo;
            }
        }

        $idespecialidade = $request->input('cmbEspecialidade');

        if(isset($idespecialidade)){
            if($idespecialidade != 0){
                $openFiltroAvancado = true;
                $oportunidades = $oportunidades->where('oportunidade.idespecialidade', '=', $idespecialidade);
                $filtroObject->idespecialidade = $idespecialidade;
            }
        }
        
        $especialidades = $this->getEspecialidades();

        foreach($especialidades as $esp){
            if($esp->id == $idespecialidade){
                $esp->checked = true;
                break;
            }
        }

        $idstatus = $request->input('status');
        $statusBanco = $this->getStatus();
        
        if(isset($idstatus)){
            if($idstatus != 0){
                $openFiltroAvancado = true;
                $oportunidades = $oportunidades->where('oportunidade.idoportunidade_status', '=', $idstatus);
                $filtroObject->idstatus = $idstatus;
            }
        }

        foreach($statusBanco as $st){
            if($st->id == $idstatus){
                $st->checked = true;
                break;
            }
        }

        $oportunidades = $oportunidades->get();
        Session::put('openFiltroAvancado', $openFiltroAvancado);
        Session::put('filtroObject', $filtroObject);
        $filtroObject->openFiltroAvancado = $openFiltroAvancado;

        return view('oportunidades/consultaOportunidades', ["oportunidades" => $oportunidades, 
            "filtroObject" => $filtroObject, "especialidades" => $especialidades, 'successMsg' => $successMsg,
            "status" => $statusBanco, "openFiltroAvancado" => $openFiltroAvancado]);
    }

    public function autocompleteCRM(Request $request)
    {   
        $term = $request->query->GET('term');
        $medicos = Medico::select('medico.id', 'medico.crm', 'medico.crm_uf', 'pessoa_fisica.nome as nomeMedico')
                            ->join('pessoa', 'pessoa.id', 'medico.idpessoa')
                            ->join('pessoa_fisica', 'pessoa_fisica.idpessoa', 'pessoa.id')   
                            ->where('medico.crm', 'like', '%' . $term . '%')
                            ->get();
        return $medicos;
    }

    public function autocompleteMedico(Request $request)
    {   
        $term = $request->query->GET('term');
        $medicos = Medico::select('medico.id', 'medico.crm', 'medico.crm_uf', 'pessoa_fisica.nome as nomeMedico')
                            ->join('pessoa', 'pessoa.id', 'medico.idpessoa')
                            ->join('pessoa_fisica', 'pessoa_fisica.idpessoa', 'pessoa.id')   
                            ->where('pessoa_fisica.nome', 'like', '%' . $term . '%')
                            ->get();
        return $medicos;
    }
    
    private function getEspecialidades()
    {
        return Especialidade::select('especialidade.id', 'especialidade.nome')->get();
    }

    private function queryMedicoDispinibilidade()
    {
        return MedicoDisponibilidade::select('medico_disponibilidade.id', 
                                                'pessoa_fisica.nome as disponibilidadeMedicoNome', 
                                                'medico.crm as disponibilidadeMedicoCrm',
                                                'medico.crm_uf as disponibilidadeMedicoCrmUf',
                                                'contato.contato as disponibilidadeMedicoTelefone',
                                                'oportunidade_tipo.nome as disponibilidadeMedicoOportunidadeTipoNome',
                                                'especialidade.nome as disponibilidadeMedicoEspecialidadeNome',
                                                'medico_disponibilidade.segunda as disponibilidadeMedicoDiaSemana',
                                                'medico_disponibilidade.terca as terca',
                                                'medico_disponibilidade.quarta as quarta',
                                                'medico_disponibilidade.quinta as quinta',
                                                'medico_disponibilidade.sexta as sexta',
                                                'medico_disponibilidade.sabado as sabado',
                                                'medico_disponibilidade.domingo as domingo',
                                                'medico_disponibilidade.data_inicio_especifica as disponibilidadeMedicoData',
                                                'medico_disponibilidade.hora_inicio as disponibilidadeMedicoHoraInicio',
                                                'medico_disponibilidade.hora_termino as disponibilidadeMedicoHoraTermino')
                                        ->join('medico_especialidade', 'medico_especialidade.id', 'medico_disponibilidade.idmedico_especialidade')
                                        ->join('medico', 'medico.id', 'medico_especialidade.idmedico')
                                        ->join('pessoa', 'pessoa.id', 'medico.idpessoa')
                                        ->join('pessoa_fisica', 'pessoa_fisica.idpessoa', 'pessoa.id')                                        
                                        ->join('contato', 'contato.idpessoa', 'pessoa.id')
                                        ->join('oportunidade_tipo', 'oportunidade_tipo.id', 'medico_disponibilidade.idoportunidade_tipo')
                                        ->join('especialidade', 'especialidade.id', 'medico_especialidade.idespecialidade')
                                        ->where(['contato.idtipo_contato' => '1']);
                                        

    }

    private function getStatus()
    {
        return \App\Models\OportunidadeStatusBD::select('oportunidade_status.id', 'oportunidade_status.nome')->get();
    }

    private function montaFiltro($filtroObject) 
    {
        if(!isset($filtroObject)){
            $filtroObject = new \stdClass();
        }
        if(!isset($filtroObject->codigo)) {
            $filtroObject->codigo = '';
        }
        if(!isset($filtroObject->idoportunidade_tipo)) {
            $filtroObject->idoportunidade_tipo = null;
        }

        return $filtroObject;
    }

    private function priorizar($id) 
    {
        $oportunidade = Oportunidade::find($id);
        $oportunidade->idoportunidade_tipo = OportunidadeTipo::Prioritarias;
        $oportunidade->save();
    }
}
