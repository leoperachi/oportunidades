<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Oportunidade;
use App\Models\Medico;
use App\Models\Especialidade;
use App\Models\OportunidadeMedicosInteressados;

class AcompanhamentoOportunidadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index($id)
    {
        
        $especialidades = $this->getEspecialidades();
        $oportunidadesMedicosInteressados = [];
        if(isset($id)){
            $oportunidade = $this->queryOportunidades()
                ->where("oportunidade.id", "=", $id)->get()[0];

            $oportunidade->dataStr = "";
            if(isset($oportunidade->data_inicio)){
                $oportunidade->dataStr = $oportunidade->data_inicio;
            }
            
            $oportunidade->horaStr = "";
            if(isset($oportunidade->hora_inicio)){
                $oportunidade->horaStr = $oportunidade->hora_inicio;
            }

            $oportunidade->intervaloStr = "";
            if(isset($oportunidade->hora_inicio_intervalo)){
                $oportunidade->horaStr = $oportunidade->horaStr . 
                    " - " . $oportunidade->hora_inicio_intervalo;
            }

            if(isset($oportunidade->hora_final_intervalo)){
                $oportunidade->horaStr = $oportunidade->horaStr . 
                    " - " . $oportunidade->hora_final_intervalo;
            }

            if(isset($oportunidade->hora_final)){
                $oportunidade->horaStr = $oportunidade->horaStr . 
                    " - " . $oportunidade->hora_final;
            }

            if(isset($oportunidade->segunda))
            {
                $oportunidade->diaDaSemana = 'Segunda';
            }
            else if(isset($oportunidade->terca))
            {
                $oportunidade->diaDaSemana = 'Terca';
            }
            else if(isset($oportunidade->quarta))
            {
                $oportunidade->diaDaSemana = 'Quarta';
            }
            else if(isset($oportunidade->quinta))
            {
                $oportunidade->diaDaSemana = 'Quinta';
            }
            else if(isset($oportunidade->sexta))
            {
                $oportunidade->diaDaSemana = 'Sexta';
            }
            else if(isset($oportunidade->sabado))
            {
                $oportunidade->diaDaSemana = 'Sabado';
            }
            else if(isset($oportunidade->domingo))
            {
                $oportunidade->diaDaSemana = 'Domingo';
            }
            else 
            {
                $oportunidade->diaDaSemana = 'A combinar';
            }

            foreach($especialidades as $esp){
                if($esp->id == $oportunidade->idespecialidade){
                    $esp->checked = true;
                    break;
                }
            }

            $oportunidadesMedicosInteressados = $this
                ->getMedicosInteressados($oportunidade->id);
        }

        if(isset($oportunidade->frequencia)){
            switch($oportunidade->frequencia){
                case 'S':
                    $oportunidade->frequenciaStr = 'Semanal';
                    break;
                case 'Q':
                    $oportunidade->frequenciaStr = 'Quizenal';
                    break;
                case 'M':
                    $oportunidade->frequenciaStr = 'Mensal';
                    break;
                default:
                    $oportunidade->frequenciaStr = '';
                    break;
            }
        }

        $primeiraIdOportunidade = Oportunidade::min('id');
        $ultIdOportunidade = Oportunidade::max('id');

        return view('oportunidades/acompanhamentoOportunidades', 
            [
                "oportunidade" =>  $oportunidade, "especialidades" => $especialidades, 
                "primeiraIdOportunidade" => $primeiraIdOportunidade,
                "ultIdOportunidade" => $ultIdOportunidade,
                "oportunidadesMedicosInteressados" => $oportunidadesMedicosInteressados,
                
            ]);
    }

    public function selecionar(Request $request)
    {
        $idOportMedInt = $request->query->GET('idOportMedInt');
        $omi = OportunidadeMedicosInteressados::find($idOportMedInt);

        if(isset($omi)){
            $oportunidade = Oportunidade::find($omi->idoportunidade);
            if(isset($oportunidade)){
                $oportunidade->idmedico = $omi->idmedico;
                $oportunidade->save();

                $m = Medico::select("pessoa_fisica.nome as nomeMedico")
                    ->join('pessoa_fisica', 'medico.idpessoa', 'pessoa_fisica.idpessoa')
                    ->where('medico.id', '=', $omi->idmedico)
                    ->get();

                return $m[0]->nomeMedico;
            }
            else{
                throw new \Exception('Não encontrou Oportunidade');
            }
        }
        else {
            throw new \Exception('Não encontrou Oportunidade Medico Interessado');
        }
    }

    public function cancelar(Request $request){
        $idOportMedInt = $request->query->GET('idOportMedInt');
        $omi = OportunidadeMedicosInteressados::find($idOportMedInt);
        if(isset($omi)){
            $oportunidade = Oportunidade::find($omi->idoportunidade);
            if(isset($oportunidade)){
                $oportunidade->idmedico = null;
                $oportunidade->save();
                
                $m = Medico::select("pessoa_fisica.nome as nomeMedico")
                    ->join('pessoa_fisica', 'medico.idpessoa', 'pessoa_fisica.idpessoa')
                    ->where('medico.id', '=', $omi->idmedico)
                    ->get();

                return $m[0]->nomeMedico;
            }
            else{
                throw new \Exception('Não encontrou Oportunidade');
            }
        }
        else {
            throw new \Exception('Não encontrou Oportunidade Medico Interessado');
        }
    }

    public function proximoAnterior(Request $request)
    {
        $tipo = $request->query->GET('tipo');
        $idOportunidade = $request->query->GET('idOportunidade');

        if($tipo == 'anterior'){
            $primeiraIdOportunidade = Oportunidade::min('id');
            while($idOportunidade > $primeiraIdOportunidade){
                $idOportunidade = $idOportunidade - 1;
                $opt = Oportunidade::find($idOportunidade);
                if(isset($opt)){
                    return $idOportunidade;
                }
            }
        }else{
            $ultIdOportunidade = Oportunidade::max('id');
            while($idOportunidade < $ultIdOportunidade){
                $idOportunidade = $idOportunidade + 1;
                $opt = Oportunidade::find($idOportunidade);
                if(isset($opt)){
                    return $idOportunidade;
                }
            }
        }

        return 0;
    }

    private function queryOportunidades()
    {
        return Oportunidade::select('oportunidade.*', 
                                    'oportunidade_tipo.nome as oportunidadeTipoNome', 
                                    'oportunidade_status.nome as statusNome',
                                    'especialidade.nome as especialidadeNome',
                                    'oportunidade_cliente.nome as oportunidadeClienteNome', 
                                    'oportunidade_cliente.id as oportunidadeClienteId')
            ->join('oportunidade_tipo', 'oportunidade.idoportunidade_tipo', 'oportunidade_tipo.id')
            ->join('oportunidade_status', 'oportunidade.idoportunidade_status', 'oportunidade_status.id')
            ->join('especialidade', 'oportunidade.idespecialidade', 'especialidade.id')
            ->join('oportunidade_cliente', 'oportunidade.idoportunidade_cliente', 'oportunidade_cliente.id');
    }

    private function getEspecialidades()
    {
        return Especialidade::select('especialidade.id', 'especialidade.nome')->get();
    }

    private function getMedicosInteressados($idoportunidade)
    {
        return OportunidadeMedicosInteressados::select("oportunidade_medicos_interessados.*", 
                                                        "medico.crm as crmMedico", 
                                                        "medico.crm_uf as crmMedicoUf",
                                                        "medico.email as email",
                                                        "medico.telefone as telefone",
                                                        "pessoa_fisica.nome as nomeMedico" )
                                                ->join('medico', 'oportunidade_medicos_interessados.idmedico', 'medico.id')
                                                ->join('pessoa_fisica', 'medico.idpessoa', 'pessoa_fisica.idpessoa')
                                                ->where("oportunidade_medicos_interessados.idoportunidade", "=", $idoportunidade)
                                                ->get();

    }
}