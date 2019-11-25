<?php

namespace App\Http\Controllers;

use Session;
use Illuminate\Http\Request;
use App\Models\Especialidade;
use App\Models\MedicoEspecialidade;
use App\Models\MedicoOportunidadeCliente;
use App\Models\OportunidadeCliente;
use Exception;

class ClienteMedicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $medicoCLientesQuery = $this->montaQuery();
        $medicoCLientes = $medicoCLientesQuery->get();

        $filtroObject = $this->montaFiltro(null);

        return view('medicosClientes.listar', 
            [ 
                'medicoCLientes' => $medicoCLientes, 
                'filtroObject' => $filtroObject 
            ]);
    }

    public function consultar(Request $request) 
    {
        $medicoCLientesQuery = $this->montaQuery();
        $filtroObject = $this->montaFiltro(null);

        $idMedicoCRM = $request['txtIdMedicoCRM'];

        if(isset($idMedicoCRM)){
            $medicoCLientesQuery = $medicoCLientesQuery
                ->where('medico.id', '=', $idMedicoCRM); 

            $filtroObject->nomeMedico =  $request['txtMedico'];
            $filtroObject->crmMedico =  $request['txtCRM'];
            $filtroObject->idMedico =  $idMedicoCRM;
        }

        $idMedico = $request['txtIdMedico'];

        if(isset($idMedico) and $idMedico != 0){
            $medicoCLientesQuery = $medicoCLientesQuery
                ->where('medico.id', '=', $idMedico);
                
            $filtroObject->nomeMedico =  $request['txtMedico'];
            $filtroObject->crmMedico =  $request['txtCRM'];
            $filtroObject->idMedico =  $idMedico;
        }

        $idCliente = $request['txtIdCliente'];

        if(isset($idCliente) and $idCliente != 0){
            $medicoCLientesQuery = $medicoCLientesQuery
                ->where('oportunidade_cliente.id', '=', $idCliente); 
            
            $filtroObject->nomeCliente =  $request['txtCliente'];
            $filtroObject->idCliente =  $request['txtIdCliente'];
        }

        $medicoCLientes =  $medicoCLientesQuery->get();

        return view('medicosClientes.listar', 
            [ 
                'medicoCLientes' => $medicoCLientes, 
                'filtroObject' => $filtroObject 
            ]);
    }

    public function editar($id)
    {
        $medicoOportunidadeCliente = $this->montaQuery()
            ->where('medico_oportunidade_cliente.id', '=', $id)
            ->get();

        $medicoEspecialidade = MedicoEspecialidade::select('medico_especialidade.idespecialidade')
            ->where('medico_especialidade.idmedico','=',  $medicoOportunidadeCliente[0]->idmedico)
            ->get();
        
        $especialidades = Especialidade::select('id', 'nome')
            ->whereIn('especialidade.id', $medicoEspecialidade->toArray())
            ->get();

        $medicoOportunidadeClientes = MedicoOportunidadeCliente::select('idoportunidade_cliente')
                ->where('medico_oportunidade_cliente.idmedico', '=', $medicoOportunidadeCliente[0]->idmedico)
                ->get();
        
        $clientes = OportunidadeCliente::select('id', 'nome')
            ->whereIn('oportunidade_cliente.id', $medicoOportunidadeClientes->toArray())
            ->get();
        
            
        return view('medicosClientes.editar', [ "especialidades" => $especialidades, "clientes" => $clientes])
            ->with('medicoOportunidadeCliente', $medicoOportunidadeCliente[0]);
    }

    public function inserir(){
        return view('medicosClientes.editar')
            ->with('medicoOportunidadeCliente', 
                $this->montaMedicoOportunidadeCliente());
    }

    private function montaMedicoOportunidadeCliente(){
        $medicoOportunidadeCliente = new \stdClass();
        $medicoOportunidadeCliente->idMedico = 0;
        $medicoOportunidadeCliente->crmMedico = '';
        $medicoOportunidadeCliente->nomeMedico = '';
        $medicoOportunidadeCliente->clienteNome = '';
        $medicoOportunidadeCliente->idCliente = 0;
        return $medicoOportunidadeCliente;
    }

    private function montaQuery()
    {
        return MedicoOportunidadeCliente::select("medico_oportunidade_cliente.*", 
            "medico.crm as crmMedico", 
            "medico.crm_uf as crmMedicoUf", 
            "medico.email as emailMedico",
            "medico.telefone as foneMedico",
            "pessoa_fisica.nome as nomeMedico",
            "pessoa_fisica.data_nascimento as dtNascMedico",
            "oportunidade_cliente.nome as clienteNome")
                ->join('medico', 'medico_oportunidade_cliente.idmedico', 'medico.id')
                ->join('pessoa_fisica', 'medico.idpessoa', 'pessoa_fisica.idpessoa')
                ->join('oportunidade_cliente','medico_oportunidade_cliente.idoportunidade_cliente','oportunidade_cliente.id');
    }

    private function montaFiltro($filtroObject) 
    {
        if(!isset($filtroObject)){
            $filtroObject = new \stdClass();
        }

        if(!isset($filtroObject->idMedico)){
            $filtroObject->idMedico = 0;
        }

        if(!isset($filtroObject->nomeMedico)){
            $filtroObject->nomeMedico = '';
        }

        if(!isset($filtroObject->crmMedico)){
            $filtroObject->crmMedico = '';
        }

        if(!isset($filtroObject->idCliente)){
            $filtroObject->idCliente = 0;
        }

        if(!isset($filtroObject->emailMedico)){
            $filtroObject->emailMedico = '';
        }

        if(!isset($filtroObject->nomeCliente)){
            $filtroObject->nomeCliente = '';
        }

        if(!isset($filtroObject->emailMedico)){
            $filtroObject->emailMedico = '';
        }

        if(!isset($filtroObject->dtNascMedico)){
            $filtroObject->dtNascMedico = '';
        }

        if(!isset($filtroObject->foneMedico)){
            $filtroObject->foneMedico = '';
        }

        if(!isset($filtroObject->foneMedico)){
            $filtroObject->foneMedico = '';
        }

        return $filtroObject;
    }
}