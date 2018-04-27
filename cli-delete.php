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
$idcli = isset($_GET['idcli']) ? $_GET['idcli'] : null;
 
// valida o ID
if (empty($idcli))
{
      echo "<script>
      alert('OH OH... ISSO NÃO ERA PARA ACONTECER. O ID NÃO FOI FORNECIDO!!!');
      window.history.back()           
      </script>";
      exit;
}

//Define o diretório de destino do arquivo
define('DEST_DIR', __DIR__ . '/arquivos');

// Conecta ao BD MySql
$PDO = db_connect();

// SQL para selecionar os registros
$sql = "SELECT nome_cli, email_cli, senha_cli, imglogo_cli FROM tbl_cli WHERE id_cli = :idcli";
 
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idcli', $idcli);
$stmt->execute();

// Define variável com array formada pela query
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (count($user) <= 0)
{
    echo "<script>
          alert('EI, MR. DART VADER. NÃO ENCONTRAMOS NENHUM REGISTRO NO BD PARA ESSE ID!');
          window.history.back()
		  </script>";
    exit;
}


$filename = DEST_DIR . '/' . $user["imglogo_cli"];

if (file_exists($filename)) {

  // Deleta o arquivo
  unlink(DEST_DIR . '/' . $user["imglogo_cli"]);

  // Deleta o registro
  $sql = "DELETE FROM tbl_cli WHERE id_cli = :idcli";
  $stmt = $PDO->prepare($sql);
  $stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
   
  if ($stmt->execute())
  {
      echo "<script>
            alert('APAGAMOS O REGISTRO NO DB E O LOGOTIPO. ERA ISSO QUE VOCÊ QUERIA?... ESPERO QUE SIM...');
            window.history.back()
        </script>";
  }
  else
  {

    echo "<script>
          alert('ERRO: ".print_r($stmt->errorInfo())."');
          window.history.back()
         </script>";
    exit;

  }


} else {
    echo "O arquivo $filename não existe";

  // Deleta o registro
  $sql = "DELETE FROM tbl_cli WHERE id_cli = :idcli";
  $stmt = $PDO->prepare($sql);
  $stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
   
  if ($stmt->execute())
  {
    echo "<script>
          alert('EI, BOB ESPONJA... APAGAMOS O REGISTRO NO DB E O ARQUIVO DO LOGO!');
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

}