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
$name = isset($_POST['nome_adm']) ? $_POST['nome_adm'] : null;
$email = isset($_POST['email_adm']) ? $_POST['email_adm'] : null;
$senha = isset($_POST['senha_adm']) ? $_POST['senha_adm'] : null;

// Validação simples. Confere se a variável tem algum valor
if (empty($name) || empty($email) || empty($senha))
{
    echo "<script>
          alert('VOLTE E PREENCHA TODOS OS CAMPOS!');
          window.history.back()
		  </script>";
    exit;
}

// Cria o hash da senha
$passwordHash = make_hash($senha);
 
// Insere os dados em tbl_adm
$PDO = db_connect();
$sql = "INSERT INTO tbl_adm(nome_adm, email_adm, senha_adm) VALUES(:name, :email, :senha)";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':name', $name);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':senha', $passwordHash);

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