<?php
 
require_once 'init.php';
 
// pega os dados do formuário
$name = isset($_POST['nome_usr']) ? $_POST['nome_usr'] : null;
$email = isset($_POST['email_usr']) ? $_POST['email_usr'] : null;
$senha = isset($_POST['senha_usr']) ? $_POST['senha_usr'] : null;
$cliente = isset($_POST['cliente']) ? $_POST['cliente'] : null; 


// validação (bem simples, só pra evitar dados vazios)
if (empty($name) || empty($email) || empty($senha) || empty($cliente)) {

	echo '<script type="text/javascript">
	alert("Volte e preencha todos os campos.");
	window.history.back()
    </script>';

    exit;

}

$PDO = db_connect();

$sql = "SELECT COUNT(*) FROM tbl_usuario WHERE email_usr = :email";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':email', $email);
$stmt->execute();
$total = $stmt->fetchColumn();
//$users = $stmt->fetchAll(PDO::FETCH_ASSOC);	

if ($total > 0):

	echo '<script type="text/javascript">
	alert("O email'.$email.' já foi cadastrado. Volte e digite outro email.");
	window.history.back()
	</script>';

	exit;

else:

// cria o hash da senha
$passwordHash = make_hash($senha);

	//Insere todas as informações no BD

	$sql_auto = "INSERT INTO tbl_usuario (id_cli, nome_usr, email_usr, senha_usr) VALUES(:cliId, :name, :email, :senha)";
	$stmt_auto = $PDO->prepare($sql_auto);
	$stmt_auto->bindParam(':cliId', $cliente);			
	$stmt_auto->bindParam(':name', $name);
	$stmt_auto->bindParam(':email', $email);
	$stmt_auto->bindParam(':senha', $passwordHash);

	if ($stmt_auto->execute()){

		$sql_ind = "SELECT * FROM tbl_usuario WHERE email_usr = :email AND senha_usr = :password";
		$stmt_ind = $PDO->prepare($sql_ind);
		 
		$stmt_ind->bindParam(':email', $email);
		$stmt_ind->bindParam(':password', $passwordHash);
		 
		$stmt_ind->execute();
		 
		$users_ind = $stmt_ind->fetchAll(PDO::FETCH_ASSOC);				
		
		$user_ind = $users_ind[0];
		
		session_start();
		$_SESSION['logged_usr'] = true;
		$_SESSION['user_id'] = $user_ind['id_usr'];
		$_SESSION['user_name'] = $user_ind['nome_usr'];
		$_SESSION['id_cliente'] = $user_ind['id_cli'];  


	    header('Location: index.php');

	}else{

	    echo "Erro ao cadastrar";
	    print_r($stmt->errorInfo());

	}
 
endif;