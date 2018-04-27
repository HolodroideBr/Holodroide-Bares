<?php
 
// inclui o arquivo de inicialização
require 'include/init.php';
 
// resgata variáveis do formulário
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
 
if (empty($email) || empty($password))
{
    echo '<script type="text/javascript">
          alert("NANANINANÃO... NADA FEITO.\nVOLTE E PRENCHA EMAIL E SENHA!");
          window.history.back()
          </script>';
        exit;
}
 
// cria o hash da senha
$passwordHash = make_hash($password);
 
$PDO = db_connect();
 
$sql = "SELECT id_cli, nome_cli, imglogo_cli FROM tbl_cli WHERE email_cli = :email AND senha_cli = :password";
$stmt = $PDO->prepare($sql);
 
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $passwordHash);
 
$stmt->execute();
 
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
 
if (count($users) <= 0)
{
    echo "<script>
          alert('Email ou senha incorretos!');
          window.history.back()
		  </script>";
    exit;
}
 
// pega o primeiro usuário
$user = $users[0];
 
session_start();
	$_SESSION['cli_logged'] = true;
	$_SESSION['cli_id'] = $user['id_cli'];
	$_SESSION['cli_name'] = $user['nome_cli'];
  $_SESSION['cli_img'] = $user['imglogo_cli'];
 
header('Location: index.php');