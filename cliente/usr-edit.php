<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Faz o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';

// resgata os valores do formulário
$nameusr = isset($_POST['nome_usr']) ? $_POST['nome_usr'] : null;
$emailusr = isset($_POST['email_usr']) ? $_POST['email_usr'] : null;
$idusr = isset($_POST['idusr']) ? $_POST['idusr'] : null;

// validação (bem simples, só pra evitar dados vazios)
if (empty($nameusr) || empty($emailusr)) {
		echo '<script type="text/javascript">
		alert("Volte e preencha todos os campos.");
		window.history.back()
        </script>';

        exit;
}


		// Atualiza o BD, menos a senha
		$PDO = db_connect();
		$sql = "UPDATE tbl_usr SET nome_usr = :nameusr, email_usr = :emailusr   WHERE id_usr = :idusr";
		$stmt = $PDO->prepare($sql);
		$stmt->bindParam(':nameusr', $nameusr);
		$stmt->bindParam(':emailusr', $emailusr);
		$stmt->bindParam(':idusr', $idusr, PDO::PARAM_INT);

		// Se a query for executada, redireciona para o painel admin  
		if ($stmt->execute()){
		    echo "<script>
	        alert('Cadastro atualizado com sucesso!');
            window.history.back()	        
     		</script>";
		    exit;     		


		// Se a query não for executada, exibe alerta com msg de erro e volta para página anterior
		}else{

		    echo "<script>
		          alert('ERRO: ".print_r($stmt->errorInfo())."');
		          window.history.back()
				  </script>";
		    exit;

		}
