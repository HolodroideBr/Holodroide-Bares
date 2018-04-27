<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Fas o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php'; 
 
// pega o ID da URL
$idcnt = isset($_GET['idcnt']) ? (int) $_GET['idcnt'] : null;
$idusr = isset($_GET['idusr']) ? (int) $_GET['idusr'] : null;
$nomecli = isset($_GET['nomecli']) ? $_GET['nomecli'] : null;
$idcli = $_SESSION['cli_id'];
 
// valida o ID
if (empty($idcnt))
{
    echo "<script>
          alert('NÃO RECEBEMOS O ID!... VÁ PARA A LUUUUZZZ...!');
          window.history.back()
		  </script>";
    exit;
}
 
// remove do banco
$PDO = db_connect();
$sql = "DELETE FROM tbl_cnt_usr WHERE id_cnt = :idcnt";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idcnt', $idcnt, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    header('Location: usr-relatorio-conteudo.php?idcli='.$idcli.'&idusr='.$idusr.'');
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