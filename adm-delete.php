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
$idadm = isset($_GET['idadm']) ? $_GET['idadm'] : null;
 
// Validação simples. Confere se a variável tem algum valor
if (empty($idadm))
{
    echo "<script>
          alert('ID NÃO INFORMADO!');
          window.history.back()
		  </script>";
    exit;
}

// Conecta ao MySql
$PDO = db_connect();
 
// Executa query para remover registro em tbl_adm
$sql = "DELETE FROM tbl_adm WHERE id_adm = :idadm";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idadm', $idadm, PDO::PARAM_INT);

// Se a query foi executada, redireciona para painel admin 
if ($stmt->execute())
{
    header('Location: adm-painel.php');
}

// Se a query não foi executada, exibe alerta e volta para página anterior
else
{
    echo "<script>
          alert('ERRO: ".print_r($stmt->errorInfo())."');
          window.history.back()
		  </script>";
    exit;
}