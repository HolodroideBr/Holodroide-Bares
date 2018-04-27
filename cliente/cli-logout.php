<?php
 
// inicia a sessão
session_start();
 
// muda o valor de logged_in para false
$_SESSION['cli_logged'] = false;
 
// finaliza a sessão
//session_destroy();
unset( $_SESSION['cli_logged'] ); 
 
// retorna para a index.php
header('Location: index.php');