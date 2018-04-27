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
$namecli = isset($_POST['nome_cli']) ? $_POST['nome_cli'] : null;
$emailcli = isset($_POST['email_cli']) ? $_POST['email_cli'] : null;
$idcli = $_SESSION['cli_id'];


$arquivo = $_FILES['imglogo_cli'];

//Define o diretório de destino do arquivo
define('DEST_DIR', __DIR__ . '/arquivos');


// se o [name] NÃO estiver vazio, é porque um arquivo foi enviado, então 
// será feita a atualização do arquiv de imagem deletando o anterior e subindo um novo.
if (isset($_FILES['imglogo_cli']) && !empty($_FILES['imglogo_cli']['name'])){

	// Conexão com BD
	$PDO = db_connect();

	// SQL para selecionar os registros
	$sql = "SELECT imglogo_cli FROM tbl_cli WHERE id_cli = :idcli";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

	//Se so select retornar $user vazio, alerta do erro e retorna para pág anterior.
	if (count($user) <= 0){
	    echo "<script>
	          alert('NENHUM REGISTRO ENCONTRADO PARA ESSE ID!');
	          window.history.back()
			  </script>";
	    exit;
	}



    $name = ''; $type = ''; $size = ''; $error = '';
	function compress_image($source_url, $destination_url, $quality) {

		$info = getimagesize($source_url);

    		if ($info['mime'] == 'image/jpeg')
        			$image = imagecreatefromjpeg($source_url);

    		elseif ($info['mime'] == 'image/gif')
        			$image = imagecreatefromgif($source_url);

   		elseif ($info['mime'] == 'image/png')
        			$image = imagecreatefrompng($source_url);

    		imagejpeg($image, $destination_url, $quality);
		return $destination_url;
	}
























	

	//Valida o tipo de imagem
	if(!preg_match('/^(image)\/(jpeg|png)$/', $arquivo['type'])){
		
		echo '<script>
		alert("Extensão inválida. Apenas arquivos jpeg e png são aceitos.");
		window.history.back()
		</script>';
		exit;
	}

	// Caso não ocorra nehum erro, gera nome único para o arquivo
	// Pega a extensão do arquivo
    $ext = explode('.', $arquivo['name']);
    $ext = end($ext);
 
    // Gera o novo nome
    $novoNome = uniqid() . '.' . $ext;

    if (!move_uploaded_file($arquivo['tmp_name'], DEST_DIR . '/' . $novoNome)){

        echo '<script type="text/javascript">
        alert("ERRO NO UPLOAD. O REGISTRO NÃO FOI ALTERADO!");
		window.history.back()
        </script>';
        exit;

    } else {

		// Atualiza o BD, menos a senha
		$PDO = db_connect();
		$sql = "UPDATE tbl_cli SET nome_cli = :namecli, email_cli = :emailcli, imglogo_cli = :img  WHERE id_cli = :idcli";
		$stmt = $PDO->prepare($sql);
		$stmt->bindParam(':namecli', $namecli);
		$stmt->bindParam(':emailcli', $emailcli);
		$stmt->bindParam(':img', $novoNome);
		$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
		
		$_SESSION['cli_name'] = $namecli;
		 
		if ($stmt->execute()){


			// Verifica se o arquivo existe no diretório e deleta
			$filename = DEST_DIR . '/' . $user["imglogo_cli"];
			if (file_exists($filename)) {

				unlink(DEST_DIR . '/' . $user["imglogo_cli"]);

			}

     	      echo "<script>
	          alert('CADASTRO ATUALIZADO COM SUCESSO!');
	          window.history.back(-2)	          
			  </script>";
	    exit;
	  }
  }

} else {

	// Se não foi enviado nenhum arquivo, apenas atualiza info de cadastro no BD, menos a senha.
	$PDO = db_connect();
	$sql = "UPDATE tbl_cli SET nome_cli = :namecli, email_cli = :emailcli  WHERE id_cli = :idcli";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':namecli', $namecli);
	$stmt->bindParam(':emailcli', $emailcli);
	$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);

	$_SESSION['cli_name'] = $namecli;
	 
	if ($stmt->execute()){

	      echo "<script>
          alert('CADASTRO ATUALIZADO COM SUCESSO!');
          window.history.back(-2)
		  </script>";
	exit;
    
    }

}