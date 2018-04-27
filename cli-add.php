<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Fas o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';
 
// Recebe dados do ofrmulário e defini variáveis usadas nas querys SQL
$empresa = isset($_POST['empresa_cli']) ? $_POST['empresa_cli'] : null;
$name = isset($_POST['nome_cli']) ? $_POST['nome_cli'] : null;
$email = isset($_POST['email_cli']) ? $_POST['email_cli'] : null;
$senha = isset($_POST['senha_cli']) ? $_POST['senha_cli'] : null;
$tipo_txt = isset($_POST['tipo_txt']) ? $_POST['tipo_txt'] : null;
$tipo_img = isset($_POST['tipo_img']) ? $_POST['tipo_img'] : null;
$tipo_vid = isset($_POST['tipo_vid']) ? $_POST['tipo_vid'] : null;
$arquivo = $_FILES['imglogo_cli'];
 
// Validação simples de dados recebidos. Confere se campo do form é vazio
if (empty($name) || empty($email) || empty($senha) || empty($empresa))
{
		echo '<script type="text/javascript">
		alert("Volte e preencha todos os campos.");
		window.history.back()
        </script>';
        exit;
}

// Cria o Hash da senha com função make_hash contida em init.php
$passwordHash = make_hash($senha);

// Defini variáveis para validar upload de imagens
//$largura = 300; //300px
//$altura = 300; //300px
//$tamanho = 100000; //1Mb


// Define o diretório de destino do arquivo recebido
define('DEST_DIR', __DIR__ . '/cliente/arquivos');

	// Se o parametro da imagem "name" estiver vazio, é porque nenhum arquivo foi enviado
	if (isset($_FILES['imglogo_cli']) && !empty($_FILES['imglogo_cli']['name'])){
	     
		// Valida o tipo de imagem (jpg ou png).
		// Aqui é possível incluir outras extenções permitidas
		if(!preg_match('/^(image)\/(jpeg|png)$/', $arquivo['type'])){
			
			echo '<script>
			alert("Extensão inválida. Apenas arquivos jpeg e png são aceitos.");
			window.history.back()
			</script>';
			exit;
		}

		// Valida as dimensões do arquivo recebido
		/*$dimensoes = getimagesize($arquivo['tmp_name']);
		if($dimensoes[0] > $largura || $dimensoes[1] > $altura){
			
			echo '<script>
			alert("Imagem fora das dimensões aceitas 280X180px");
			window.history.back()
			</script>';
			exit;
		}*/

		// Valida o tamanho (peso) do arquivo recebido
	/*	if($arquivo['size'] > $tamanho){
			
			echo '<script>
			alert("Imagem acima do peso permitido. Máximo: 1Mb.");
			window.history.back()
			</script>';
			exit;			

		}*/

		// Caso não ocorra nehum erro, gera nome único para o arquivo recebido
		// Divide o nome do arquivo e defini variável para a extenção do arquivo
	   

	    $ext = explode('.', $arquivo['name']);
	    $ext = end($ext);
	 
	    // Gera o nome único para o arquivo recebido e inclui a string da extenção
	    $novoNome = uniqid() . '.' . $ext;

        // Faz o upload para o diretório definico acima
	    if (!move_uploaded_file($arquivo['tmp_name'], DEST_DIR . '/' . $novoNome)){

	        echo '<script type="text/javascript">
			        alert("ERRO NO UPLOAD. O CADASTRO NÃO FOI FEITO!");
					window.history.back()
			        </script>';
	        exit;

	    }else{



			// Define variáveis para o nome do arquivo de redirect .php que será criado
			$redirCli = uniqid().'.php';


			$nameNoSpc = retiraAcentos(utf8_decode($name));
			$NomeTxt = $nameNoSpc.'-txt-'.$redirCli;
			$NomeImg = $nameNoSpc.'-img-'.$redirCli;
			$NomeVid = $nameNoSpc.'-vid-'.$redirCli;
			
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


			// Insere todas as informações no BD MySql
			$PDO = db_connect();
			$sql = "INSERT INTO tbl_cli (empresa_cli, nome_cli, email_cli, senha_cli, imglogo_cli, tipo_txt, tipo_img, tipo_vid, redir_cli) VALUES(:empresa, :name, :email, :senha, :img, :tipotxt, :tipoimg, :tipovid, :redircli)";
			$stmt = $PDO->prepare($sql);
			$stmt->bindParam(':empresa', $empresa);			
			$stmt->bindParam(':name', $name);
			$stmt->bindParam(':email', $email);
			$stmt->bindParam(':senha', $passwordHash);
			$stmt->bindParam(':img', $novoNome);
			$stmt->bindParam(':tipotxt', $tipo_txt);			
			$stmt->bindParam(':tipoimg', $tipo_img);			
			$stmt->bindParam(':tipovid', $tipo_vid);		
			$stmt->bindParam(':redircli', $redirCli);	
			$stmt->execute();
			$lastId = $PDO->lastInsertId();


			// Insere todas as informações no BD
			$sql1 = "INSERT INTO tbl_usr (id_cli, nome_usr, email_usr, senha_usr, redir_usr) VALUES(:idcli, :nameusr, :emailusr, :senhausr, :redirusr)";
			$stmt = $PDO->prepare($sql1);
			$stmt->bindParam(':idcli', $lastId);			
			$stmt->bindParam(':nameusr', $name);
			$stmt->bindParam(':emailusr', $email);
			$stmt->bindParam(':senhausr', $passwordHash);
			$stmt->bindParam(':redirusr', $redirCli);
			$stmt->execute();
			$lastId1 = $PDO->lastInsertId();


			// Se não foi enviado nenhum arquivo, apenas atualiza info de cadastro no BD, menos a senha.
			$sql = "UPDATE tbl_cli SET usr_cli = :usrcli WHERE id_cli = :idcli";
			$stmt = $PDO->prepare($sql);
			$stmt->bindParam(':usrcli', $lastId1, PDO::PARAM_INT);
			$stmt->bindParam(':idcli', $lastId, PDO::PARAM_INT);



			 
			if ($stmt->execute()){

			    // Se o INSERT teve sucesso, redireciona para o painel de clientes
			    header('Location: cli-painel.php');

			}else{



			    // Caso aconteça erro na execução do INSERT, exibe mensagem de erro
			   echo "<script>
			          alert('ERRO: ".print_r($stmt->errorInfo())."');
			          window.history.back()
					  </script>";
			    exit;

			}
		}

	}else{

		// Se não recebe nenhum arquivo para upload, exibe mensagem de erro
		echo '<script type="text/javascript">
		alert("VOLTE E ESCOLHA UM ARQUIVO PARA UPLOAD!");
		window.history.back()
        </script>';
        exit;

	}
