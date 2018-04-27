<?php

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Fas o Hash de senha  
require_once 'init.php';

// Se NÃO existe a sessão do administrador, então redireciona para formulário de login.
if (!UsrIsLoggedIn())
{
    header('Location: https://holodroide.com/sistema/usuario/index.php');
}