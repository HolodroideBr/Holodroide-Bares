<?php
session_start();
 
require_once '../init.php';
 
require '../check.php'; 
 
// pega o ID da URL
$id = isset($_GET['id']) ? $_GET['id'] : null;
 
// valida o ID
if (empty($id))
{
    echo "ID não informado";
    exit;
}

//Define o diretório de destino do arquivo
define('DEST_DIR', __DIR__ . '/arquivos');

$PDO = db_connect();

// SQL para selecionar os registros
$sql = "SELECT nome_cli, email_cli, senha_cli, imglogo_cli FROM tbl_cliente WHERE id_cli = :id";
 
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':id', $id);
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


$filename = DEST_DIR . '/' . $user["imglogo_cli"];

if (file_exists($filename)) {

//deleta o arquivo
unlink(DEST_DIR . '/' . $user["imglogo_cli"]);

//deleta o registro
$sql = "DELETE FROM tbl_cliente WHERE id_cli = :id";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    echo "<script>
          alert('Arquivo e Registro apagados.');
          window.history.back()
      </script>";
}
else
{
    echo "Erro ao remover";
    print_r($stmt->errorInfo());
}


} else {
    echo "O arquivo $filename não existe";

//deleta o registro
$sql = "DELETE FROM tbl_cliente WHERE id_cli = :id";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':id', $id, PDO::PARAM_INT);
 
if ($stmt->execute())
{
    echo "<script>
          alert('Arquivo e Registro apagados.');
          window.history.back()
      </script>";
}
else
{
    echo "Erro ao remover";
    print_r($stmt->errorInfo());
}

}