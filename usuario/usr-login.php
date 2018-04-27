<?php
 
// inclui o arquivo de inicialização
require '../include/init.php';
 
// resgata variáveis do formulário
$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
 
if (empty($email) || empty($password))
{
    echo "Informe email e senha";
    exit;
}
 
// cria o hash da senha
$passwordHash = make_hash($password);

$PDO = db_connect();
 
$sql = "SELECT * FROM tbl_usr WHERE email_usr = :email AND senha_usr = :password";
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
	$_SESSION['usr_logged'] = true;
	$_SESSION['usr_id'] = $user['id_usr'];
	$_SESSION['usr_name'] = $user['nome_usr'];
  $_SESSION['id_cli'] = $user['id_cli'];  

header('Location: index.php');
