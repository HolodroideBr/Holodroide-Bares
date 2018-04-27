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
$password = isset($_POST['senha_usr']) ? $_POST['senha_usr'] : null;
$id = isset($_POST['id']) ? $_POST['id'] : null;
 
// validação (bem simples, mais uma vez)
if (empty($password))
{
    echo "Volte e digite a nova senha.";
    exit;
}

// cria o hash da senha
$passwordHash = make_hash($password);
 
// atualiza o banco
$PDO = db_connect();
$sql = "UPDATE tbl_usuario SET senha_usr = :senha  WHERE id_usr = :id";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':senha', $passwordHash);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    header('Location: painel-user.php');
}
else
{
    echo "Erro ao alterar";
    print_r($stmt->errorInfo());
}