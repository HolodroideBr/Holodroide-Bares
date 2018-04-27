<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Fas o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';
 
// resgata os valores do formulário
$password = isset($_POST['senha_cli']) ? $_POST['senha_cli'] : null;
$idusr = isset($_POST['idusr']) ? $_POST['idusr'] : null;
$idcli = $idcli = $_SESSION['cli_id'];
 
// validação (bem simples, mais uma vez)
if (empty($password))
{
    echo "<script>
          alert('EI, CHEWBACCA... VOLTE E DIGITE A NOVA SENHA!');
          window.history.back()
		  </script>";
    exit;
}

// cria o hash da senha
$passwordHash = make_hash($password);
 
// atualiza o banco
$PDO = db_connect();
$sql = "UPDATE tbl_cli SET senha_cli = :senhacli  WHERE id_cli = :idcli";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':senhacli', $passwordHash);
$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
$stmt->execute();


$sql = "UPDATE tbl_usr SET senha_usr = :senhacli  WHERE id_usr = :idusr";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':senhacli', $passwordHash);
$stmt->bindParam(':idusr', $idusr, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    echo "<script>
          alert('SENHA ALTERADA COM SUCESSO!');
          window.history.back()
      </script>";
    exit;
}
else
{
    // Caso aconteça erro na execução do INSERT, exibe mensagem de erro
    echo "<script>
          alert('ERRO: ".print_r($stmt->errorInfo())."');
          window.history.back()
         </script>";
    exit;
}