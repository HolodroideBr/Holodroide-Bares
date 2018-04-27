<?php
 
// inclui o arquivo de inicialização
require '../include/init.php';
 
// resgata variáveis do formulário
$email = $_POST['login'];
$password = $_POST['senha'];
 
// cria o hash da senha
$passwordHash = make_hash($password);

$PDO = db_connect();
$sql = "SELECT COUNT(*) AS total FROM tbl_usr WHERE email_usr = :email AND senha_usr = :password";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $passwordHash);
$stmt->execute();
$total = $stmt->fetchColumn();

  if ($total > 0){
echo "1"; //retorno = 1, usuário pode logar


  }else{
    echo "0";
        
  }
