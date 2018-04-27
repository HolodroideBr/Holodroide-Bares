<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Faz o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';
 
// Recebe os dados do formulário e define as variáveis
$idcli = isset($_POST['idcli']) ? $_POST['idcli'] : null;
$nameusr = isset($_POST['nome_usr']) ? $_POST['nome_usr'] : null;
$emailusr = isset($_POST['email_usr']) ? $_POST['email_usr'] : null;
$senhausr = isset($_POST['senha_usr']) ? $_POST['senha_usr'] : null;



// Validação simples. Confere se a variável tem algum valor
if (empty($nameusr) || empty($emailusr) || empty($senhausr) || empty($idcli)) {
		echo '<script type="text/javascript">
		alert("Volte e preencha todos os campos.");
		window.history.back()
        </script>';
        exit;
}



// Define variáveis para o nome do arquivo de redirect .php que será criado
$redirusr = uniqid().'.php';
$nameNoSpc = retiraAcentos(utf8_decode($nameusr));
$NomeTxt = $nameNoSpc.'-txt-'.$redirusr;
$NomeImg = $nameNoSpc.'-img-'.$redirusr;
$NomeVid = $nameNoSpc.'-vid-'.$redirusr;

// Define variável para o conteúdo do arquivo
$txtredir = '';

// Cria arquivo php para redirect do txt usado na app
$file = fopen('uploaders/redirect/'.$NomeTxt, 'w');
fwrite($file, $txtredir);
fclose($file);

// Cria arquivo php para redirect do img usado na app
$file = fopen('uploaders/redirect/'.$NomeImg, 'w');
fwrite($file, $txtredir);
fclose($file);

// Cria arquivo php para redirect do vid usado na app
$file = fopen('uploaders/redirect/'.$NomeVid, 'w');
fwrite($file, $txtredir);
fclose($file);

// Cria o hash da senha
$passwordHash = make_hash($senhausr);

// Insere todas as informações no BD
$PDO = db_connect();
$sql = "INSERT INTO tbl_usr (id_cli, nome_usr, email_usr, senha_usr, redir_usr) VALUES(:idcli, :nameusr, :emailusr, :senhausr, :redirusr)";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idcli', $idcli);			
$stmt->bindParam(':nameusr', $nameusr);
$stmt->bindParam(':emailusr', $emailusr);
$stmt->bindParam(':senhausr', $passwordHash);
$stmt->bindParam(':redirusr', $redirusr);

// Se a query for executada, redireciona para o painel admin  
if ($stmt->execute()){

    header('Location: usr-painel.php');

// Se a query não for executada, exibe alerta com msg de erro e volta para página anterior
}else{

    echo "<script>
          alert('ERRO: ".print_r($stmt->errorInfo())."');
          window.history.back()
		  </script>";
    exit;

}
