<?php

namespace App\Models;

abstract class OportunidadeStatus
{
    const Cancelada = 1;
    const Aberta = 2;
    const Inativa = 3;
    const Concluida = 4;
    const Prioritarias = 5;
    const Erro = 6;
    const Importado = 7;
    const Importacao_Iniciada = 8;
    const Importacao_Concluida = 9;
    const Com_Candidato = 10;
}

