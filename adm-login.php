<?php
// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Fas o Hash de senha 
require_once 'include/init.php';

// Recebe os dados do formulário e define as variáveis
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Validação simples. Confere se a variável tem algum valor 
if (empty($email) || empty($password))
{
    echo "<script>
          alert('INFORM EMAIL E SENHA!');
          window.history.back()
      </script>";
    exit;
}
 
// Cria o hash da senha
$passwordHash = make_hash($password);
 
$PDO = db_connect();
 
// Executa query para procurar email e senha em tbl_adm 
$sql = "SELECT id_adm, nome_adm FROM tbl_adm WHERE email_adm = :email AND senha_adm = :password";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $passwordHash);
$stmt->execute();

// Define variável com array do resultado da query 
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
// Se a query retornar vazio, exibe alerta e volta para tela anterior
if (count($users) <= 0)
{
    echo "<script>
          alert('EMAIL OU SENHA INCORRETOS!');
          window.history.back()
    		  </script>";
    exit;
}
 
// Se o resultado da query não for vazio, seleciona o primeiro resultado
$user = $users[0];

// Escreve as sessões de administrador (login, id e nome) para navegação no sistema 
session_start();
	$_SESSION['adm_logged'] = true;
	$_SESSION['adm_id'] = $user['id_adm'];
	$_SESSION['adm_name'] = $user['nome_adm'];

// Redireciona para index.php já com as seções criadas que permite exibir menu 
header('Location: index.php');