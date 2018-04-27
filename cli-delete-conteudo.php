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
$idcont = isset($_GET['idcont']) ? (int) $_GET['idcont'] : null;
$idcli = isset($_GET['idcli']) ? (int) $_GET['idcli'] : null;
 
// valida o ID
if (empty($idcont))
{
    echo "ID não informado";
    exit;
}
 
// remove do banco
$PDO = db_connect();
$sql = "DELETE FROM tbl_conteudo_usr WHERE id_cont = :idcont";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idcont', $idcont, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    header('Location: relatorio-conteudo-cli.php?id='.$idcli.'');
}
else
{
    echo "Erro ao remover";
    print_r($stmt->errorInfo());
}