<?php
 
// Inicia a sessão
session_start();
 
// Muda o valor de adm_logged para false
$_SESSION['adm_logged'] = false;
 
// Finaliza a sessão
//session_destroy();
unset( $_SESSION['adm_logged'] ); 
// Retorna para a index.php
header('Location: index.php');