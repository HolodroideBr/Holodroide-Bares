<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Faz o Hash de senha 
require_once 'include/init.php';

 
// resgata os valores do formulário
$password = isset($_POST['senha_usr']) ? $_POST['senha_usr'] : null;
$idusr = isset($_POST['idusr']) ? $_POST['idusr'] : null;
 
// validação (bem simples, mais uma vez)
if (empty($password))
{
    echo '<script type="text/javascript">
    alert("SANTO ERRO, BATMAN!\nVOLTE E DIGITE A NOVA SENHA PARA O USUÁRIO!!!");
    window.history.back()
        </script>';

        exit;
}

// Cria o hash da senha
$passwordHash = make_hash($password);
 
// atualiza o banco
$PDO = db_connect();
$sql = "UPDATE tbl_usr SET senha_usr = :senha  WHERE id_usr = :idusr";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':senha', $passwordHash);
$stmt->bindParam(':idusr', $idusr, PDO::PARAM_INT);

// Se a query for executada, redireciona para o painel admin   
if ($stmt->execute())
{

			    echo "<script>
		          alert('SENHA ALTERADA COM SUCESSO!');
		          window.location = 'index.php';
				  </script>";
                  //header('Location: index.php');

		// Se a query não for executada, exibe alerta com msg de erro e volta para página anterior
		}else{

		    echo "<script>
		          alert('ERRO: ".print_r($stmt->errorInfo())."');
		          window.history.back()
				  </script>";
		    exit;
}