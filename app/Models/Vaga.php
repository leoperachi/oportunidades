<?php


namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Vaga extends Model
{

    protected $table = 'vaga';

    public function sala()
    {

        return $this->belongsTo(Sala::class, 'idsala');
    }

    public function especialidade()
    {

        return $this->belongsTo(Especialidade::class, 'idespecialidade');
    }


    public function dataInicioFormatada()
    {

        $dataInicio = $this->data_inicio;

        $dataInicioFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $dataInicio);
        return $dataInicioFormatada->format('d/m/Y');
    }

    public function dataInicioHoraFormatada()
    {

        $dataInicio = $this->data_inicio;

        $dataInicioFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $dataInicio);
        return $dataInicioFormatada->format('d/m/Y H:i:s');
    }

    public function dataInicioSoHoraFormatada()
    {

        $dataInicio = $this->data_inicio;

        $dataInicioFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $dataInicio);
        return $dataInicioFormatada->format('H:i:s');
    }

    public function dataFinalFormatada()
    {

        $dataFinal = $this->data_final;

        $dataFinalFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $dataFinal);
        return $dataFinalFormatada->format('d/m/Y');
    }

    public function dataFinalHoraFormatada()
    {

        $dataFinal = $this->data_final;

        $dataFinalFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $dataFinal);
        return $dataFinalFormatada->format('d/m/Y H:i:s');
    }

    public function dataFinalSoHoraFormatada()
    {

        $dataFinal = $this->data_final;

        $dataFinalFormatada = Carbon::createFromFormat('Y-m-d H:i:s', $dataFinal);
        return $dataFinalFormatada->format('H:i:s');
    }
}