<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Fas o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';
 
// Recebe os dados do formulário e define as variáveis
$password = isset($_POST['senha_adm']) ? $_POST['senha_adm'] : null;
$idadm = isset($_POST['idadm']) ? $_POST['idadm'] : null;
 
// Validação (bem simples, mais uma vez)
if (empty($password))
{
    echo "<script>
          alert('VOLTE E DIGITE A NOVA SENHA!');
          window.history.back()
		  </script>";
    exit;
}

// Cria o hash da senha
$passwordHash = make_hash($password);
 
// Conecta BD MySql
$PDO = db_connect();

// Executa query para atualizar tablea tbl_adm
$sql = "UPDATE tbl_adm SET senha_adm = :senha  WHERE id_adm = :idadm";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':senha', $passwordHash);
$stmt->bindParam(':idadm', $idadm, PDO::PARAM_INT);
 
// Se a query for executada, redireciona para o painel admin  
if ($stmt->execute())
{
    header('Location: adm-painel.php');
}
// Se a query não for executada, exibe alerta com msg de erro e volta para página anterior
else
{
    echo "<script>
          alert('ERRO: ".print_r($stmt->errorInfo())."');
          window.history.back()
		  </script>";
    exit;
}