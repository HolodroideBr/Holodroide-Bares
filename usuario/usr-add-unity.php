<?php
 
require '../include/init.php';
 
// pega os dados do formuário
//$name = $_POST['nome'];
//$email = $_POST['email'];
//$senha = $_POST['senha'];
//$cliente = $_POST['cliente']; 

$name = $_GET['nome'];
$email = $_GET['email'];
$senha = $_GET['senha'];
$cliente = ""; 

$PDO = db_connect();
$sql = "SELECT COUNT(*) FROM tbl_usuario WHERE email_usr = :email";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$total = $stmt->fetchColumn();
//$users = $stmt->fetchAll(PDO::FETCH_ASSOC);	

if ($total > 0):

	echo "0";

else:

// cria o hash da senha
$passwordHash = make_hash($senha);

	//Insere todas as informações no BD

	$sql_auto = "INSERT INTO tbl_usr (id_cli, nome_usr, email_usr, senha_usr) VALUES(:cliId, :name, :email, :senha)";
	$stmt_auto = $PDO->prepare($sql_auto);
	$stmt_auto->bindParam(':cliId', $cliente);			
	$stmt_auto->bindParam(':name', $name);
	$stmt_auto->bindParam(':email', $email);
	$stmt_auto->bindParam(':senha', $passwordHash);
	$stmt_auto->execute();

	echo "1";
 
endif;