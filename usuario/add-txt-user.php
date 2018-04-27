<?php
 
require_once 'init.php';
 
// pega os dados do formuário
$userTxt = isset($_POST['addition']) ? $_POST['addition'] : null;
 
// validação (bem simples, só pra evitar dados vazios)
if (empty($userTxt)) {
		echo '<script type="text/javascript">
		alert("Volte e digite um texto.");
		window.history.back()
        </script>';
        exit;
}

			//Insere todas as informações no BD
			$PDO = db_connect();
			$sql = "INSERT INTO tbl_conteudo_usr(id_usr, data_conteudo, text_usr, status_conteudo ) VALUES(:id, :datetxt, :usrtxt, :status )";
			$stmt = $PDO->prepare($sql);
			$stmt->bindParam(':id', $id);
			$stmt->bindParam(':datetxt', date);			
			$stmt->bindParam(':usrtxt', $userTxt);
			$stmt->bindParam(':status', 'N');			

			 
			if ($stmt->execute()){

			    header('Location: painel-user.php');

			}else{

			    echo "Erro ao cadastrar";
			    print_r($stmt->errorInfo());

			}
