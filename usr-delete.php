<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Faz o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';
 
// pega o ID da URL
$idusr = isset($_GET['idusr']) ? $_GET['idusr'] : null;
 
// valida o ID
if (empty($idusr))
{
    echo "<script>
          alert('SQUASH NA ÁREA, MANINHO...\nVOCÊ NÃO INFORMOU NENHUM ID. MMMM...');
          window.history.back()
      </script>";
    exit;
}


$PDO = db_connect();

// SQL para selecionar os registros
$sql = "SELECT * FROM tbl_usr WHERE id_usr = :idusr";
 
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idusr', $idusr);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (count($user) <= 0)
{
    echo "<script>
          alert('Erro: Nenhum cliente encontrado para esse id.');
          window.history.back()
		  </script>";
    exit;
}


//deleta o registro
$sql = "DELETE FROM tbl_usr WHERE id_usr = :idusr";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idusr', $idusr, PDO::PARAM_INT);

// Se a query for executada, redireciona para o painel admin    
if ($stmt->execute())
{
    echo "<script>
          alert('Registro apagado.');
          window.history.back()
      </script>";

    // Se a query não for executada, exibe alerta com msg de erro e volta para página anterior
    }else{

        echo "<script>
              alert('ERRO: ".print_r($stmt->errorInfo())."');
              window.history.back()
          </script>";
        exit;
}