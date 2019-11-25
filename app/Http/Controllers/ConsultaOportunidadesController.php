<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Models\Oportunidade;
use App\Models\Especialidade;
use App\Models\OportunidadeCliente;
use App\Models\OportunidadeStatusBD;
use App\Models\OportunidadeTipo;

class ConsultaOportunidadesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $oportunidades = [];
        $especialidades = $this->getEspecialidades();
        $status = $this->getStatus();
        $filtroObject = new \stdClass();
        $filtroObject = $this->montaFiltro($filtroObject);

        $filtroObject->idoportunidade_tipo = null;
        if(!isset($filtroObject->openFiltroAvancado)) 
        {
            $filtroObject->openFiltroAvancado = true;
        }

        foreach($oportunidades as $oportunidade){
            $oportunidade->diaSemanastr = $this->toDiaSemanaStr($oportunidade);
        }
        
        return view('oportunidades/consultaOportunidades', ["oportunidades" => $oportunidades, 
            "especialidades" => $especialidades, "status" => $status, "filtroObject" => $filtroObject]);
    }

    public function consultar(Request $request) 
    {
        $acao = $request->get('acao');
        $successMsg = null;
        $limpar = false;
        
        if(isset($acao)){
            if($request->get('acao') == 'priorizar'){
                $idStr = '';
                foreach($request->input('chkOportunidade') as $id){
                    $this->priorizar($id);
                    $idStr = $idStr . $id . ',';
                }
                $successMsg = 'Oportunidades ' . substr($idStr, 0, -1) . ' priorizadas';
            }else if($request->get('acao') == 'despriorizar'){
                $idStr = '';
                foreach($request->input('chkOportunidade') as $id){
                    $this->despriorizar($id);
                    $idStr = $idStr . $id . ',';
                }
                $successMsg = 'Oportunidades ' . substr($idStr, 0, -1) . ' despriorizadas';
            }else if($request->get('acao') == 'limpar'){
                $limpar = true;
            }
        }

        $filtroObject = new \stdClass();
        $filtroObject = $this->montaFiltro($filtroObject);
        $oportunidades = $this->queryOportunidades();

        if(!$limpar){

            $id = $request['codigo'];

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
                    if($idoportunidade_tipo == OportunidadeTipo::Prioritarias){
                        $oportunidades = $oportunidades->where('oportunidade.prioridade', '=', 1);
                        $filtroObject->chkPrioritarias = true;
                    }else{
                        $oportunidades = $oportunidades->where('oportunidade.idoportunidade_tipo', '=', $idoportunidade_tipo);
                        $filtroObject->idoportunidade_tipo = $idoportunidade_tipo;
                        if($idoportunidade_tipo == OportunidadeTipo::Recorrentes){
                            $filtroObject->chkRecorrentes = true;
                        }
                        else{
                            $filtroObject->chkEventuais = true;
                        }
                    }

                    $filtroObject->openFiltroAvancado = true;
                }
            }

            $dtInicio = $request->input('txtDtInicio');
            $dtFinal = $request->input('txtDtFinal');

            if(isset($dtInicio) and isset($dtFinal)){
                if($dtInicio != '' and $dtFinal != ''){
                    $dtInicioArr = explode('/', $dtInicio);
                    $data_inicio = sprintf('%02d-%02d-%02d', $dtInicioArr[2], $dtInicioArr[0], $dtInicioArr[1]);
                    $filtroObject->dtInicio = $dtInicio;

                    $dtFinalArr = explode('/', $dtFinal);
                    $data_final = sprintf('%02d-%02d-%02d', $dtFinalArr[2], $dtFinalArr[0], $dtFinalArr[1]);
                    $filtroObject->dtFinal = $dtFinal;
                    $oportunidades = $oportunidades->whereBetween('oportunidade.data_inicio', [$data_inicio, $data_final]);
                    $filtroObject->openFiltroAvancado = true;
                }
            }
            else if(isset($dtInicio)){
                if($dtInicio != ''){
                    $dtInicioArr = explode('/', $dtInicio);
                    $data_inicio = sprintf('%02d-%02d-%02d', $dtInicioArr[2], $dtInicioArr[1], $dtInicioArr[0]);
                    $oportunidades = $oportunidades->whereDate('oportunidade.data_inicio', '>=', $data_inicio);
                    $filtroObject->dtInicio = $dtInicio;
                    $filtroObject->openFiltroAvancado = true;
                }
            }
            else if(isset($dtFinal)){
                if($dtFinal != ''){
                    $dtFinalArr = explode('/', $dtFinal);
                    $data_final = sprintf('%02d-%02d-%02d', $dtFinalArr[2], $dtFinalArr[1], $dtFinalArr[0]);
                    $oportunidades = $oportunidades->whereDate('oportunidade.data_final', '<=', strtotime($dtFinal));
                    $filtroObject->dtFinal = $dtFinal;
                }
            }

            $periodoini = $request['txtperini'];
            $periodofim = $request['txtperfim'];

            if(isset($periodoini) and isset($periodofim)){
                $filtroObject->periodoini =  $periodoini;
                $filtroObject->periodofim = $periodofim;
                $oportunidades = $oportunidades
                    ->where('oportunidade.hora_inicio','>=',$periodoini)
                    ->where('oportunidade.hora_final','<=',$periodofim);
                
                $filtroObject->openFiltroAvancado = true;
            }

            $idCliente = $request['txtIdCliente'];
            if(isset($idCliente) and $idCliente > 0){
                $oportunidades = $oportunidades->where('oportunidade.idoportunidade_cliente', '=', $idCliente);
                $filtroObject->idCliente = $idCliente;
                $filtroObject->nomeCliente = $request->input('txtCliente');
                $filtroObject->openFiltroAvancado = true;
            }
        }
        

        $idstatus = $request['status'];
        $statusBanco = $this->getStatus();
        
        if(isset($idstatus) and !$limpar){
            if($idstatus != 0){
                $filtroObject->openFiltroAvancado = true;
                $oportunidades = $oportunidades
                    ->where('oportunidade.idoportunidade_status', '=', $idstatus);
                $filtroObject->idstatus = $idstatus;
            }
        }

        foreach($statusBanco as $st){
            if($st->id == $idstatus and !$limpar){
                $st->checked = true;
                break;
            }
        }

        $idespecialidade = $request['cmbEspecialidade'];

        if(isset($idespecialidade) and !$limpar){
            if($idespecialidade != 0){
                $filtroObject->openFiltroAvancado = true;
                $oportunidades = $oportunidades
                    ->where('oportunidade.idespecialidade', '=', $idespecialidade);
                $filtroObject->idespecialidade = $idespecialidade;
            }
        }
        
        $especialidades = $this->getEspecialidades();

        foreach($especialidades as $esp){
            if($esp->id == $idespecialidade and !$limpar){
                $esp->checked = true;
                break;
            }
        }

        $oportunidades = $oportunidades->orderBy('oportunidade.prioridade', 'DESC')->get();

        if(!$limpar){
            $chkSeg = $request->input('chkSeg');
            $chkTer = $request->input('chkTer');
            $chkQua = $request->input('chkQua');
            $chkQui = $request->input('chkQui');
            $chkSex = $request->input('chkSex');
            $chkSab = $request->input('chkSab');
            $chkDom = $request->input('chkDom');
            $chkCombinar = $request->input('chkCombinar');

            if(isset($chkSeg) or isset($chkTer) or isset($chkQua) or isset($chkQui) 
                or isset($chkSex) or isset($chkSab) or isset($chkDom) or isset($chkCombinar)){

                $oportunidades = $this->filtraSemana($oportunidades, $chkSeg, $chkTer,  
                    $chkQua, $chkQui, $chkSex,  $chkSab, $chkDom, $chkCombinar);

                $filtroObject->seg  = $chkSeg;
                $filtroObject->ter  = $chkTer;
                $filtroObject->qua  = $chkQua;
                $filtroObject->qui  = $chkQui;
                $filtroObject->sex  = $chkSex;
                $filtroObject->sab  = $chkSab;
                $filtroObject->dom  = $chkDom;
                $filtroObject->comb = $chkCombinar;

                $filtroObject->openFiltroAvancado = true;
            }
        }

        foreach($oportunidades as $oportunidade){
            $oportunidade->diaSemanastr = $this->toDiaSemanaStr($oportunidade);
            $oportunidade->periodo = $this->getPeriodo($oportunidade);
        }

        return view('oportunidades/consultaOportunidades', ["oportunidades" => $oportunidades, 
            "filtroObject" => $filtroObject, "especialidades" => $especialidades, 
            'successMsg' => $successMsg, "status" => $statusBanco]);
    }

    public function autocomplete_cliente(Request $request)
    {
        $term = $request->query->GET('term');
        $clientes = OportunidadeCliente::select('oportunidade_cliente.nome', 'oportunidade_cliente.id')
            ->where('oportunidade_cliente.nome', 'like', '%' . $term . '%')
            ->get();

        return $clientes;
    }

    private function getPeriodo($oportunidade){
        $retorno = '';
        $aux = explode(":", $oportunidade->hora_inicio);

        if(count($aux) > 1){
            $retorno = $retorno . $oportunidade->hora_inicio;
        }
        else{
            return 'A Combinar';
        }

        if(isset($oportunidade->hora_inicio_intervalo) and 
            isset($oportunidade->hora_final_intervalo)){
            $retorno = $retorno . ' - ' . $oportunidade->hora_inicio_intervalo . 
                ' - ' . $oportunidade->hora_final_intervalo;
        }

        $retorno = $retorno . ' - ' . $oportunidade->hora_final;

        return $retorno;
    }

    private function filtraSemana($oportunidades, $chkSeg, $chkTer,  
        $chkQua, $chkQui, $chkSex,  $chkSab, $chkDom, $chkCombinar) {
        
        $retorno = [];
        foreach($oportunidades as  $oportunidade){
            if($chkSeg and $oportunidade->segunda == 1){
                array_push($retorno, $oportunidade);
            }else if($chkTer and $oportunidade->terca == 1){
                array_push($retorno, $oportunidade);
            }else if($chkQua and $oportunidade->quarta == 1){
                array_push($retorno, $oportunidade);
            }else if($chkQui and $oportunidade->quinta == 1){
                array_push($retorno, $oportunidade);
            }else if($chkSex and $oportunidade->sexta == 1){
                array_push($retorno, $oportunidade);
            }else if($chkSab and $oportunidade->sabado == 1){
                array_push($retorno, $oportunidade);
            }else if($chkDom and $oportunidade->domingo == 1){
                array_push($retorno, $oportunidade);
            }else if($chkCombinar and $oportunidade->combinar == 1){
                array_push($retorno, $oportunidade);
            }
        }

        return $retorno;
    }

    private function getEspecialidades()
    {
        return Especialidade::select('especialidade.id', 'especialidade.nome')->get();
    }

    private function queryOportunidades()
    {
        return Oportunidade::select('oportunidade.*', 
                                    'oportunidade_tipo.nome as oportunidadeTipoNome', 
                                    'oportunidade_status.nome as statusNome',
                                    'especialidade.nome as especialidadeNome',
                                    'oportunidade_cliente.nome as oportunidadeClienteNome')
            ->join('oportunidade_tipo', 'oportunidade.idoportunidade_tipo', 'oportunidade_tipo.id')
            ->join('oportunidade_status', 'oportunidade.idoportunidade_status', 'oportunidade_status.id')
            ->join('especialidade', 'oportunidade.idespecialidade', 'especialidade.id')
            ->join('oportunidade_cliente', 'oportunidade.idoportunidade_cliente', 'oportunidade_cliente.id');
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
        if(!isset($filtroObject->nomeCliente)) {
            $filtroObject->nomeCliente = '';
        }
        if(!isset($filtroObject->idCliente)) {
            $filtroObject->idCliente = 0;
        }
        if(!isset($filtroObject->idoportunidade_tipo)) {
            $filtroObject->idoportunidade_tipo = null;
        }

        if(!isset($filtroObject->dtInicio)) {
            $filtroObject->dtInicio = '';
        }

        if(!isset($filtroObject->dtFinal)) {
            $filtroObject->dtFinal = '';
        }

        if(!isset($filtroObject->chkPrioritarias)) {
            $filtroObject->chkPrioritarias = false;
        }

        if(!isset($filtroObject->chkRecorrentes)) {
            $filtroObject->chkRecorrentes = false;
        }

        if(!isset($filtroObject->chkEventuais)) {
            $filtroObject->chkEventuais = false;
        }

        if(!isset($filtroObject->seg)) {
            $filtroObject->seg = false;
        }

        if(!isset($filtroObject->ter)) {
            $filtroObject->ter = false;
        }

        if(!isset($filtroObject->qua)) {
            $filtroObject->qua = false;
        }

        if(!isset($filtroObject->qui)) {
            $filtroObject->qui = false;
        }

        if(!isset($filtroObject->sex)) {
            $filtroObject->sex = false;
        }

        if(!isset($filtroObject->sab)) {
            $filtroObject->sab = false;
        }

        if(!isset($filtroObject->dom)) {
            $filtroObject->dom = false;
        }

        if(!isset($filtroObject->comb)) {
            $filtroObject->comb = false;
        }
        
        if(!isset($filtroObject->periodoini)) {
            $filtroObject->periodoini = '';
        }

        if(!isset($filtroObject->periodofim)) {
            $filtroObject->periodofim = false;
        }
        
        return $filtroObject;
    }

    private function priorizar($id) 
    {
        $oportunidade = Oportunidade::find($id);
        $oportunidade->prioridade = 1;
        $oportunidade->save();
    }

    private function despriorizar($id) 
    {
        $oportunidade = Oportunidade::find($id);
        $oportunidade->prioridade = 0;
        $oportunidade->save();
    }

    private function isOpenFiltro(Request $request)
    {
        $id = $request->input('codigo');
        $txtIdCliente = $request->input('txtIdCliente');
        $txtDtInicio = $request->input('txtDtInicio');
        $txtDtFinal = $request->input('txtDtFinal');

        $idoportunidade_tipos = $request->input('chkTipoOportunidade');
        if(isset($idoportunidade_tipos)){
            foreach($idoportunidade_tipos as $idoportunidade_tipo){
                return true;
            }
        }

        if(isset($id) and $id != '') {
            return true;
        }else if(isset($txtIdCliente) and $txtIdCliente != ''){
            return true;
        }else if(isset($txtDtInicio) and $txtDtInicio != ''){
            return true;
        }else if(isset($txtDtFinal) and $txtDtFinal != ''){
            return true;
        }else{
            return false;
        }
    }

    private function toDiaSemanaStr($oportunidade){
        if(isset($oportunidade->segunda) and $oportunidade->segunda == 1){
            return 'Segunda';
        }
        else if(isset($oportunidade->terca) and $oportunidade->terca == 1){
            return 'Terça';
        }
        else if(isset($oportunidade->quarta) and $oportunidade->quarta == 1){
            return 'Quarta';
        }
        else if(isset($oportunidade->quinta) and $oportunidade->quinta == 1){
            return 'Quinta';
        }
        else if(isset($oportunidade->sexta) and $oportunidade->sexta == 1){
            return 'Sexta';
        }
        else if(isset($oportunidade->sabado) and $oportunidade->sabado == 1){
            return 'Sabado';
        }
        else if(isset($oportunidade->domingo) and $oportunidade->domingo == 1){
            return 'Domingo';
        }
        else if(isset($oportunidade->combinar) and $oportunidade->combinar == 1){
            return 'À Combinar';
        }
        else{
            return '';
        }
    }
}
