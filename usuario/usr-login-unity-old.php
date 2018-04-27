<?php
 
// inclui o arquivo de inicialização
require '../include/init.php';
 
// resgata variáveis do formulário
$email = $_POST['name'];
$password = $_POST['pass'];
 
// cria o hash da senha
$passwordHash = make_hash($password);

$PDO = db_connect();
 
$sql = "SELECT * FROM tbl_usr WHERE email_usr = :email AND senha_usr = :password";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $passwordHash);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

$user = $users[0];

if (count($users) > 0)
    {
 // echo 'false';
     echo $user['email_usr'];

    }
  else
  {
    // echo 'false';
   echo 'true';
  }
