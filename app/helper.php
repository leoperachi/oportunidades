<?php
function isCadastro()
{
    return \Request::is('perfil') ? true : false;
}