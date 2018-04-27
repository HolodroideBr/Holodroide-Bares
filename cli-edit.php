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
$empresa = isset($_POST['empresa_cli']) ? $_POST['empresa_cli'] : null;
$namecli = isset($_POST['nome_cli']) ? $_POST['nome_cli'] : null;
$email = isset($_POST['email_cli']) ? $_POST['email_cli'] : null;
$idcli = isset($_POST['idcli']) ? $_POST['idcli'] : null;
$tipo_txt = isset($_POST['tipo_txt']) ? $_POST['tipo_txt'] : null;
$tipo_img = isset($_POST['tipo_img']) ? $_POST['tipo_img'] : null;
$tipo_vid = isset($_POST['tipo_vid']) ? $_POST['tipo_vid'] : null;

	// Conexão com BD
	$PDO = db_connect();

	// SQL para selecionar os registros
	$sql = "SELECT * FROM tbl_cli WHERE id_cli = :idcli";
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


// se o [name] NÃO estiver vazio, é porque um arquivo foi enviado, então 
// será feita a atualização do arquiv de imagem deletando o anterior e subindo um novo.
if (isset($_FILES['imglogo_cli']) && !empty($_FILES['imglogo_cli']['name'])){

	$arquivo = $_FILES['imglogo_cli'];


	$name = ''; $type = ''; $size = ''; $error = ''; 

	// Função php para compressão da imagem
	function compress_image($source_url, $destination_url, $quality) {
	    
	    $info = getimagesize($source_url);
	  
	    if ($info['mime'] == 'image/jpeg')
	       $image = imagecreatefromjpeg($source_url);

	    elseif ($info['mime'] == 'image/gif')
	        $image = imagecreatefromgif($source_url);

	    elseif ($info['mime'] == 'image/png')
	        $image = imagecreatefrompng($source_url);

	        // Salva o arquivo
	        // Faz a compressão. 0 (baixa qualidade, arquivo pequeno) até 100 (melhor qualidade, arquivo grande)
	        imagejpeg($image, $destination_url, $quality);
	        return $destination_url;

    }

    if ($_POST) {

	    if ($_FILES["imglogo_cli"]["error"] > 0) {
	  
	        $error = $_FILES["imglogo_cli"]["error"];

	        echo '<script>
	        alert("Erro: '.$error.'");
	        window.history.back()
	        </script>';
	        exit;

	    } else if (($_FILES["imglogo_cli"]["type"] == "image/gif") ||
	              ($_FILES["imglogo_cli"]["type"] == "image/jpeg") ||
	  		      ($_FILES["imglogo_cli"]["type"] == "image/jpg") ||
		  	      ($_FILES["imglogo_cli"]["type"] == "image/JPG") ||
	              ($_FILES["imglogo_cli"]["type"] == "image/png") ||
	              ($_FILES["imglogo_cli"]["type"] == "image/pjpeg")) {

	        $arquivo = $_FILES['imglogo_cli'];

	        //Caso não ocorra nehum erro, gera nome único para o arquivo
	        // pega a extensão do arquivo
	        $ext = explode('.', $arquivo['name']);
	        $ext = end($ext);
	     
	        // gera o novo nome
	        $novoNome = uniqid() . '.' . $ext;

	        $url = 'cliente/arquivos/'. $novoNome;
	        $filename = compress_image($_FILES["imglogo_cli"]["tmp_name"], $url, 100);

		    if (!$filename){

		        echo '<script type="text/javascript">
		        alert("ERRO NO UPLOAD. O REGISTRO NÃO FOI ALTERADO!");
				window.history.back()
		        </script>';
		        exit;

		    } else {

				// Atualiza o BD, menos a senha
				$PDO = db_connect();
				$sql = "UPDATE tbl_cli SET empresa_cli = :empresa, nome_cli = :name, email_cli = :email, imglogo_cli = :img, tipo_txt = :tipotxt, tipo_img = :tipoimg, tipo_vid = :tipovid  WHERE id_cli = :idcli";
				$stmt = $PDO->prepare($sql);
				$stmt->bindParam(':empresa', $empresa);				
				$stmt->bindParam(':name', $namecli);
				$stmt->bindParam(':email', $email);
				$stmt->bindParam(':img', $novoNome);
				$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
				$stmt->bindParam(':tipotxt', $tipo_txt);			
				$stmt->bindParam(':tipoimg', $tipo_img);			
				$stmt->bindParam(':tipovid', $tipo_vid);		
			 
				if ($stmt->execute()){
				      echo "<script>
			          alert('CADASTRO ATUALIZADO COM SUCESSO!');
			          window.history.back(-2)	          
					  </script>";
			    exit;
				
				}
		    }
	    }
	}

} else {

	// Se não foi enviado nenhum arquivo, apenas atualiza info de cadastro no BD, menos a senha.
	$PDO = db_connect();
	$sql = "UPDATE tbl_cli SET empresa_cli = :empresa, nome_cli = :name, email_cli = :email, tipo_txt = :tipotxt, tipo_img = :tipoimg, tipo_vid = :tipovid  WHERE id_cli = :idcli";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':empresa', $empresa);	
	$stmt->bindParam(':name', $namecli);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
	$stmt->bindParam(':tipotxt', $tipo_txt);			
	$stmt->bindParam(':tipoimg', $tipo_img);			
	$stmt->bindParam(':tipovid', $tipo_vid);	
	 
	if ($stmt->execute()){

	      echo "<script>
          alert('CADASTRO ATUALIZADO COM SUCESSO!');
          window.history.back(-2)
		  </script>";
	exit;
    
    }

}
?>
