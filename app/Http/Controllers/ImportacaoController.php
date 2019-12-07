<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Models\Especialidade;
use App\Models\OportunidadeCliente;
use App\Models;
use PhpOffice\PhpSpreadsheet;
use Illuminate\Support\Facades\DB;

class ImportacaoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('oportunidades/importacao');
    }

    public function importarModal(Request $request)
    {
        try{
            $arquivo = Session::get('fileUpload');
            $filename = $arquivo;
            Session::remove('fileUpload');
            $arquivoNome = 'teste';
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheets = $reader->load($filename);
           
        }catch(\InvalidArgumentException $ex){
            return view('oportunidades/importacao', ["logs" => []])
                ->with('errorMsg',$ex->getMessage());
        }catch(\ErrorException  $ex){
            return view('oportunidades/importacao', ["logs" => []])
                ->with('errorMsg',$ex->getMessage());
        }

        try{
            $eventuais = $spreadsheets->getSheetByName('Eventuais');
            $recorrentes = $spreadsheets->getSheetByName('Recorrentes');
            $hospitais = $spreadsheets->getSheetByName('Hospitais');
            if(!isset($eventuais) and !isset($recorrentes) and !isset($hospitais)){
                throw new \Exception('Arquivo não está no formato correto');
            }
            $this->inativaOportunidades();

            $impEventuais = $this->importaEventuais($arquivoNome, $eventuais);
            $idEventuais = $impEventuais->id;
        
            $impRecorrentes = $this->importaRecorrentes($arquivoNome, $recorrentes);
            $idRecorrentes = $impRecorrentes->id;
        
            $impHospitais = $this->importaHospitais($arquivoNome, $hospitais);
            $idHospitais = $impHospitais->id;

            $logs = $this->carregaLogGrid($idEventuais, $idRecorrentes, $idHospitais);
        
            return view('oportunidades/importacao', [ "logs" => $logs ])
                ->with('successMsg','Importação Concluida com Sucesso!');
        }catch(\Exception $ex){
            return view('oportunidades/importacao', ["logs" => []])
                ->with('errorMsg',$ex->getMessage());
        }
    }

    public function importar(Request $request)
    {
        try{
            $arquivoNome = $_FILES["planilhaexcel"]['name'];
            $filename = $_FILES["planilhaexcel"]['tmp_name'];
            $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader("Xlsx");
            $spreadsheets = $reader->load($filename);
        }catch(\InvalidArgumentException $ex){
            return view('oportunidades/importacao', ["logs" => []])
                ->with('errorMsg',$ex->getMessage());
        }catch(\ErrorException  $ex){
            return view('oportunidades/importacao', ["logs" => []])
                ->with('errorMsg',$ex->getMessage());
        }

        try{
            $eventuais = $spreadsheets->getSheetByName('Eventuais');
            $recorrentes = $spreadsheets->getSheetByName('Recorrentes');
            $hospitais = $spreadsheets->getSheetByName('Hospitais');
            if(!isset($eventuais) and !isset($recorrentes) and !isset($hospitais)){
                throw new \Exception('Arquivo não está no formato correto');
            }
        }catch(\Exception $ex){
            return view('oportunidades/importacao', ["logs" => []])
                ->with('errorMsg',$ex->getMessage());
        }

        if(!$this->temVagasEmAbertoComCandidato()){
            $this->inativaOportunidades();

            $impEventuais = $this->importaEventuais($arquivoNome, $eventuais);
            $idEventuais = $impEventuais->id;
        
            $impRecorrentes = $this->importaRecorrentes($arquivoNome, $recorrentes);
            $idRecorrentes = $impRecorrentes->id;
        
            $impHospitais = $this->importaHospitais($arquivoNome, $hospitais);
            $idHospitais = $impHospitais->id;

            $logs = $this->carregaLogGrid($idEventuais, $idRecorrentes, $idHospitais);
        
            return view('oportunidades/importacao', [ "logs" => $logs ])
                ->with('successMsg','Importação Concluida com Sucesso!');
        }
        else{
            $dirs = explode('\\', $filename);
            $path = '';

            for($i=0;$i<count($dirs)-1;$i++){
                if($i==0){
                    $path = $dirs[0];    
                }else{
                    $path = $path . '\\' . $dirs[$i];
                }
            }

            $destinationOfCopy = $path . '\\' . $arquivoNome;

            move_uploaded_file ($filename, $destinationOfCopy);
            Session::put('fileUpload', $destinationOfCopy);

            return view('oportunidades/importacao', [
                    "logs" => [], 
                    "nomeArquivo" => $arquivoNome
                ])
                ->with('openModal','Existem Oportunidades com Candidatos. Deseja Mesmo Importar?');
        }
    }

    private function importaEventuais($arquivoNome, $eventuais)
    {
        DB::beginTransaction();
        $importacaoEventuais = null;

        try{
            $importacaoEventuais = $this
                ->salvaEretornaImportacao(\App\Models\OportunidadeTipo::Eventuais, $arquivoNome);
            
            $this->salvaLog($importacaoEventuais->id, 
                'Importação Eventuais Começou', 8, date("Y-m-d H:i:s"));
        }catch(\Exception $e){
            $this->salvaLog(0, 'Importação Erro: ' . $e->getMessage(), 
                6, date("Y-m-d H:i:s"));
        }
        
        foreach ($eventuais->getRowIterator() as $row) {
            try{
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(TRUE);
                $proximo = $row->getRowIndex() + 1;
                if($row->getRowIndex() > 1){
                    $idxCell = 0;
                    $oportunidade = new \App\Models\Oportunidade();
                    $oportunidade->idoportunidade_tipo = 2;
                    $oportunidade->idoportunidade_importacao = $importacaoEventuais->id;
                    $oportunidade->idoportunidade_status = \App\Models\OportunidadeStatus::Aberta;

                    foreach ($cellIterator as $cell) {
                        $value = (string)$cell->getValue();
                        switch ($idxCell) {
                            case 2:
                                $value = $cell->getCalculatedValue();
                                if (strpos($value, 'Mon') !== false) {
                                    $oportunidade->segunda = '1';
                                }
                                else if (strpos($value, 'Tue') !== false) {
                                    $oportunidade->terca = '1';
                                }
                                else if (strpos($value, 'Wed') !== false) {
                                    $oportunidade->quarta = '1';
                                }
                                else if (strpos($value, 'Thu') !== false) {
                                    $oportunidade->quinta = '1';
                                }
                                else if (strpos($value, 'Fri') !== false) {
                                    $oportunidade->sexta = '1';
                                }
                                else if (strpos($value, 'Sat') !== false) {
                                    $oportunidade->sabado = '1';
                                }
                                else if (strpos($value, 'Sun') !== false) {
                                    $oportunidade->domingo = '1';
                                }
                                else{
                                    $oportunidade->combinar = '1';
                                }
                                break;
                            case 3:
                                $time = $cell->getCalculatedValue();
                                $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($time);
                                $newDate = date("Y-m-d", $in);
                                $oportunidade->data_inicio = $newDate;
                                break;
                            case 4:
                                try{
                                    $time = $cell->getValue();
                                    $hour = explode(":",$cell->getFormattedValue());
                                    $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($time)->format('Y-m-d h:i');                           
                                    $date = date('h:i A', strtotime($in));
                                    $horaminuto_arr = explode (":", $date); 
                                    $minutoampm = explode (" ", $horaminuto_arr[1]);
                                    $vsf = sprintf('%02d:%02d', $hour[0], $minutoampm[0]);
                                    $oportunidade->hora_inicio = $vsf;
                                }catch(\ErrorException $e){
                                    $oportunidade->hora_inicio = null;
                                }
                                
                                break;
                            case 5:
                                try{
                                    $time = (string)$cell->getValue();
                                    $hour = explode(":",$cell->getFormattedValue());
                                    $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($time)->format('Y-m-d h:i');
                                    $oportunidade->data_final = $in;
                                    $date = date('h:i A', strtotime($in));
                                    $horaminuto_arr = explode (":", $date); 
                                    $minutoampm = explode (" ", $horaminuto_arr[1]);
                                    $minutes = $minutoampm[0];
                                    $vsf = sprintf('%02d:%02d', $hour[0], $minutoampm[0]);
                                    $oportunidade->hora_final = $vsf;
                                }catch(\ErrorException $e){
                                    $oportunidade->hora_final = null;
                                }
                                
                                break;
                            case 6:
                                $time = $cell->getValue();
                                try{
                                    $time = (string)$cell->getValue();
                                    $hour = explode(":",$cell->getFormattedValue());
                                    $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($time)->format('Y-m-d h:i');
                                    $date = date('h:i A', strtotime($in));
                                    $horaminuto_arr = explode (":", $date); 
                                    $minutoampm = explode (" ", $horaminuto_arr[1]);
                                    $minutes = $minutoampm[0];
                                    $vsf = sprintf('%02d:%02d', $hour[0], $minutoampm[0]);
                                    $oportunidade->hora_inicio_intervalo = $vsf;
                                }catch(\ErrorException $e){
                                    $oportunidade->hora_inicio_intervalo = null;
                                }
                                
                                break;
                            case 7:
                                $time = $cell->getValue();
                                try{
                                    $time = (string)$cell->getValue();
                                    $hour = explode(":",$cell->getFormattedValue());
                                    $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($time)->format('Y-m-d h:i');
                                    $date = date('h:i A', strtotime($in));
                                    $horaminuto_arr = explode (":", $date); 
                                    $minutoampm = explode (" ", $horaminuto_arr[1]);
                                    $minutes = $minutoampm[0];
                                    $vsf = sprintf('%02d:%02d', $hour[0], $minutoampm[0]);
                                    $oportunidade->hora_final_intervalo = $vsf;
                                }catch(\ErrorException $e){
                                    $oportunidade->hora_final_intervalo = null;
                                }
                                
                                break;
                            case 10:
                                $val = $this->localizaEspecialidade($value);
                                $oportunidade->idespecialidade = $val;
                                break;
                            case 12:
                                $cliente = $this->localizaCliente($value);
                                $oportunidade->idoportunidade_cliente = $cliente->id;
                                break;
                            case 13:
                                $oportunidade->cidade = $value;
                            break;
                        }
                        $idxCell++;
                    }
                    $oportunidade->prioridade = 0;
                    $oportunidade->save();
                }
            }catch(\Exception $e){
                $this->salvaLog($importacaoEventuais->id, 
                    'Importação Erro: Linha: ' . $row->getRowIndex() . 'Mensagem:' . $e->getMessage(), 
                    6, date("Y-m-d H:i:s"));
            }

            $v = $eventuais->getCell('B'. $proximo)->getValue();

            if($v == null or $v == '' ){
                $this->salvaLog($importacaoEventuais->id, 'Termino importação', 9, date("Y-m-d H:i:s"));
                break;
            }
        }

        $this->conluiImportacao($importacaoEventuais->id);

        DB::commit();
        return $importacaoEventuais;
    }

    private function importaRecorrentes($arquivoNome, $recorrentes)
    {
        DB::beginTransaction();
        $importacaoRecorrentes = null;

        try{
            $importacaoRecorrentes = $this
                ->salvaEretornaImportacao(\App\Models\OportunidadeTipo::Recorrentes, $arquivoNome);

            $this->salvaLog($importacaoRecorrentes->id, 'Importação Recorrente Começou', 8, date("Y-m-d H:i:s"));
        }catch(\Exception $e){
            $this->salvaLog($importacaoRecorrentes->id, 'Importação Erro: '. $e->getMessage(), 6, date("Y-m-d H:i:s"));
        }

        foreach ($recorrentes->getRowIterator() as $row) {
            try{
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(TRUE);
                $proximo = $row->getRowIndex() + 1;
                
                if($row->getRowIndex() > 1){
                    $idxCell = 0;
                    $oportunidade = new \App\Models\Oportunidade();
                    $oportunidade->idoportunidade_tipo = \App\Models\OportunidadeTipo::Recorrentes;
                    $oportunidade->idoportunidade_importacao = $importacaoRecorrentes->id;
                    $oportunidade->idoportunidade_status = \App\Models\OportunidadeStatus::Aberta;

                    foreach ($cellIterator as $cell) {
                        $value = (string)$cell->getValue();
                        switch ($idxCell) {
                            case 1:
                                try{
                                    $time = $cell->getValue();
                                    $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($time);
                                    $hours = (int)($in / 3600);
                                    $minutes = round($in / 60) - ($hours * 60);
                                    $oportunidade->carga = sprintf('%02d:%02d', $hours, $minutes);;
                                }catch(\ErrorException $e){
                                    $oportunidade->carga = 'A Combinar';
                                }
                                
                                break;
                            case 2:
                                $value = (string)$cell->getFormattedValue();
                                $oportunidade->frequencia = $value;
                                break;
                            case 3:
                                if (strpos($value, 'combinar') !== false) {
                                    $oportunidade->combinar = '1';
                                }
                                else if (strpos($value, 'segunda') !== false) {
                                    $oportunidade->segunda = '1';
                                }
                                else if (strpos($value, 'terça') !== false) {
                                    $oportunidade->terca = '1';
                                }
                                else if (strpos($value, 'quarta') !== false) {
                                    $oportunidade->quarta = '1';
                                }
                                else if (strpos($value, 'quinta') !== false) {
                                    $oportunidade->quinta = '1';
                                }
                                else if (strpos($value, 'sexta') !== false) {
                                    $oportunidade->sexta = '1';
                                }
                                else if (strpos($value, 'sabado') !== false) {
                                    $oportunidade->sabado = '1';
                                }
                                else if (strpos($value, 'domingo') !== false) {
                                    $oportunidade->domingo = '1';
                                }
                                break;
                            case 5:
                                $time = $cell->getValue();
                                try{
                                    $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($time);
                                    $hours = (int)($in / 3600);
                                    $minutes = round($in / 60) - ($hours * 60);
                                    $oportunidade->hora_inicio = sprintf('%02d:%02d', $hours, $minutes);;
                                }catch(\ErrorException $e){
                                    $oportunidade->hora_inicio = 'A Combinar';
                                }
                                
                                break;
                            case 6:
                                $time = $cell->getValue();
                                try{
                                    $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($time);
                                    $hours = (int)($in / 3600);
                                    $minutes = round($in / 60) - ($hours * 60);
                                    $oportunidade->hora_final = sprintf('%02d:%02d', $hours, $minutes);;
                                }catch(\ErrorException $e){
                                    $oportunidade->hora_final = 'A Combinar';
                                }
                                
                                break;
                            case 8:
                                $cliente = $this->localizaCliente($value);
                                $oportunidade->idoportunidade_cliente = $cliente->id;
                                break;
                            case 9:
                                $oportunidade->cidade = $value;
                                break;
                            case 10:
                                $val = $this->localizaEspecialidade($value);
                                $oportunidade->idespecialidade = $val;
                                break;
                            case 16:
                                $oportunidade->tipo_atendimento = $value;
                                break;
                        }
                        
                        $idxCell++;
                    }

                    $oportunidade->prioridade = 0;
                    $oportunidade->save();
                }
            }catch(\Exception $e){
                $this->salvaLog($importacaoRecorrentes->id, 
                    'Importação Erro: Linha:' . $row->getRowIndex() . 'Mensagem:' . $e->getMessage(), 
                    6, date("Y-m-d H:i:s"));
            }

            $v = $recorrentes->getCell('B'. $proximo)->getValue();

            if($v == null or $v == '' ){
                $this->salvaLog($importacaoRecorrentes->id, 'Termino importação', 9, date("Y-m-d H:i:s"));
                break;
            }
        }

        $this->conluiImportacao($importacaoRecorrentes->id);

        DB::commit();
        return $importacaoRecorrentes;
    }

    private function importaHospitais($arquivoNome, $hospitais) 
    {
        DB::beginTransaction();
        $importacaoHospitais = null;

        try{
            $importacaoHospitais = $this
                ->salvaEretornaImportacao(\App\Models\OportunidadeTipo::Eventuais, $arquivoNome);

            $this->salvaLog($importacaoHospitais->id, 
                'Importação Hospitais Começou', 
                \App\Models\OportunidadeStatus::Importacao_Iniciada,
                 date("Y-m-d H:i:s"));

        }catch(\Exception $e){
            $this->salvaLog($importacaoHospitais->id, 
                'Importação Erro: '. $e->getMessage(), 
                \App\Models\OportunidadeStatus::Erro, 
                date("Y-m-d H:i:s"));
        }

        foreach ($hospitais->getRowIterator() as $row) {
            try{
                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(TRUE);
                $proximo = $row->getRowIndex() + 1;

                if($row->getRowIndex() > 1){
                    $idxCell = 0;
                    $oportunidade = new \App\Models\Oportunidade();
                    $oportunidade->idoportunidade_tipo = \App\Models\OportunidadeTipo::Eventuais;
                    $oportunidade->idoportunidade_importacao = $importacaoHospitais->id;
                    $oportunidade->idoportunidade_status = \App\Models\OportunidadeStatus::Aberta;

                    foreach ($cellIterator as $cell) {
                        $value = (string)$cell->getValue();
                        switch ($idxCell) {
                            case 2:
                                $value = $cell->getCalculatedValue();

                                if (strpos($value, 'Mon') !== false or strpos($value, 'Seg') !== false) {
                                    $oportunidade->segunda = '1';
                                }
                                else if (strpos($value, 'Tue') !== false or strpos($value, 'Ter') !== false) {

                                    $oportunidade->terca = '1';
                                }
                                else if (strpos($value, 'Wed') !== false or strpos($value, 'Qua') !== false) {

                                    $oportunidade->quarta = '1';
                                }
                                else if (strpos($value, 'Thu') !== false or strpos($value, 'Qui') !== false) {

                                    $oportunidade->quinta = '1';
                                }
                                else if (strpos($value, 'Fri') !== false or strpos($value, 'Sex') !== false) {

                                    $oportunidade->sexta = '1';
                                }
                                else if (strpos($value, 'Sat') !== false or strpos($value, 'Sab') !== false) {
                                        
                                    $oportunidade->sabado = '1';
                                }
                                else if (strpos($value, 'Sun') !== false or strpos($value, 'Dom') !== false) {

                                    $oportunidade->domingo = '1';
                                }
                                else {
                                    $oportunidade->combinar = '1';
                                }
                                break;
                            
                            case 4:
                                $time = $cell->getValue();
                                $hour = explode(":",$cell->getFormattedValue());
                                $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($time)->format('Y-m-d h:i');
                                $oportunidade->data_inicio =  $in;
                                $date = date('h:i A', strtotime($in));
                                $horaminuto_arr = explode(":", $date); 
                                $minutoampm = explode (" ", $horaminuto_arr[1]);
                                $vsf = sprintf('%02d:%02d', $hour[0], $minutoampm[0]);
                                $oportunidade->hora_inicio = $vsf;
                                break;
                            case 5:
                                $time = $cell->getValue();
                                $hour = explode(":",$cell->getFormattedValue());
                                $in = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($time)->format('Y-m-d h:i');
                                $oportunidade->data_final = $in;
                                $date = date('h:i A', strtotime($in));
                                $horaminuto_arr = explode (":", $date); 
                                $minutoampm = explode (" ", $horaminuto_arr[1]);
                                $vsf = sprintf('%02d:%02d', $hour[0], $minutoampm[0]);
                                $oportunidade->hora_final = $vsf;
                                break;
                            case 6:
                                $oportunidade->sala_turno = $value;
                                break;
                            case 7:
                                $val = $this->localizaEspecialidade($value);
                                $oportunidade->idespecialidade = $val;
                                break;
                            case 9:
                                $cliente = $this->localizaCliente($value);
                                $oportunidade->idoportunidade_cliente = $cliente->id;
                                break;
                        }

                        $idxCell++;
                    }

                    $oportunidade->prioridade = 0;
                    $oportunidade->save();
                }
            }catch(\Exception $e){
                $this->salvaLog($importacaoHospitais->id, 
                    'Importação Erro:  Linha: ' . $row->getRowIndex() . ' Mensagem: ' . $e->getMessage(), 
                    \App\Models\OportunidadeStatus::Erro,
                    date("Y-m-d H:i:s"));
            }

            $v = $hospitais->getCell('B'. $proximo)->getValue();

            if($v == null or $v == '' ){
                $this->salvaLog($importacaoHospitais->id, 
                    'Termino importação', 
                    \App\Models\OportunidadeStatus::Importacao_Concluida,
                    date("Y-m-d H:i:s"));
                break;
            }
        }

        $this->conluiImportacao($importacaoHospitais->id);

        DB::commit();
        return $importacaoHospitais;
    }

    private function carregaLogGrid($idEventuais, $idRecorrentes, $idHospitais)
    {
        return \App\Models\OportunidadeImportacaoLog::select('oportunidade_importacao_log.*', 
                                                             'oportunidade_importacao.nome_arquivo', 
                                                             'oportunidade_status.nome' )
            ->join('oportunidade_importacao', 'oportunidade_importacao_log.idoportunidade_importacao', 'oportunidade_importacao.id')
            ->join('oportunidade_status','oportunidade_importacao_log.idoportunidade_status','oportunidade_status.id')
            ->where('idoportunidade_importacao', '=', $idEventuais)
            ->orWhere('idoportunidade_importacao', '=', $idRecorrentes)
            ->orWhere('idoportunidade_importacao', '=', $idHospitais)
            ->get();
    }

    private function localizaEspecialidade($value)
    {
        $filtro = [];
        $especialidade = Especialidade::select('id', 'nome', 'ativo')
            ->where('especialidade.nome', '=', $value)->get();
        
        if($especialidade->count() == 1){
            $val = $especialidade[0]->id;
            return $val;
        }
        else{
            $especialidade = Especialidade::select('id', 'nome', 'ativo')
                ->where('especialidade.nome', 'like', '%' . $value . '%')->get();

            if(count($especialidade) == 1) {
                $val = $especialidade[0]->id;
                return $val;
            }
            else{
                return $this->salvaEspecialidade($value);
            }
        }
    }

    private function localizaCliente($name) 
    {
        $cliente = \App\Models\OportunidadeCliente::select('*')
            ->where('oportunidade_cliente.nome', '=', $name)->get();
        
        if($cliente->count() == 1){
            return $cliente[0];
            
        }
        else{
            $cliente = \App\Models\OportunidadeCliente::select('*')
                ->where('oportunidade_cliente.nome', 'like', '%' . $name . '%')
                ->get();
        
            if(count($cliente) == 0){
                return $this->salvaCliente($name);
            }

            return $cliente[0];
        }
    }

    private function salvaLog($idoportunidade_importacao, $mensagem, $idoportunidade_status, $dtImportacao)
    {
        $importacaoLog = new \App\Models\OportunidadeImportacaoLog();
        $importacaoLog->idoportunidade_importacao = $idoportunidade_importacao;
        $importacaoLog->log = $mensagem;
        $importacaoLog->idoportunidade_status = $idoportunidade_status;
        $importacaoLog->data_hora_importacao = $dtImportacao;
        $importacaoLog->save();
    }

    private function temVagasEmAbertoComCandidato() 
    {
        $oportunidadesCom_Candidato = \App\Models\Oportunidade::select('oportunidade.*')
            ->join('oportunidade_status', 'oportunidade.idoportunidade_status', 'oportunidade_status.id')
            ->where('oportunidade_status.id', '=', \App\Models\OportunidadeStatus::Com_Candidato)
            ->get();

        if(count($oportunidadesCom_Candidato)>0){
            return true;
        }

        return false;
    }

    private function conluiImportacao($idImportacao){
        $importacao = \App\Models\OportunidadeImportacao::findOrFail($idImportacao);
        $importacao->idoportunidade_status = \App\Models\OportunidadeStatus::Importacao_Concluida;
        $importacao->data_hora_encerramento = date("Y-m-d H:i:s");
        $importacao->save();
    }

    private function inativaOportunidades()
    {   
        $oportunidadesAbertas = \App\Models\Oportunidade::select('oportunidade.*')
            ->join('oportunidade_status', 'oportunidade.idoportunidade_status', 'oportunidade_status.id')
            ->where('oportunidade_status.id', '<>', \App\Models\OportunidadeStatus::Inativa)
            ->get();
        
        foreach($oportunidadesAbertas as $opa){
            $oportunidade = \App\Models\Oportunidade::findOrFail($opa->id);
            $oportunidade->idoportunidade_status = 3;
            $oportunidade->save();
        }
    }

    private function salvaEretornaImportacao($tipoImportacao, $arquivoNome)
    {
            $importacao = new \App\Models\OportunidadeImportacao();
            $importacao->idtipo_oportunidade = $tipoImportacao;
            $importacao->user_id = Auth::user()->id;
            $data = date("Y-m-d H:i:s");
            $importacao->data_hora_inicio = $data;
            $importacao->data_hora_encerramento = $data;
            $importacao->idoportunidade_status = \App\Models\OportunidadeStatus::Importacao_Iniciada;
            $importacao->nome_arquivo = $arquivoNome;
            $importacao->save();
            return $importacao;

    }

    private function salvaEspecialidade($nome){
        $especialide = new Especialidade();
        $especialide->nome = $nome;
        $especialide->descricao = 'inserido pelo sistema';
        $especialide->ativo = 1;
        $especialide->save();
        return $especialide->id;
    }

    private function salvaCliente($nome){
        $oportunidadeCliente = new OportunidadeCliente();
        $oportunidadeCliente->nome = $nome;
        $oportunidadeCliente->ativo = 1;
        $oportunidadeCliente->save();
        return $oportunidadeCliente;
    }
}