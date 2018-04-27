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
$idcnt = isset($_GET['idcnt']) ? (int) $_GET['idcnt'] : null;
$idcli = isset($_GET['idcli']) ? (int) $_GET['idcli'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;
$tipocnt = isset($_GET['tipocnt']) ? $_GET['tipocnt'] : null;

	// Conecta ao BD MySql
	$PDO = db_connect();

	// Atualiza todos os registros do cliente no BD para status N
	$sql = "UPDATE tbl_cnt_usr SET status_cnt = 'N' WHERE id_cli = :idcli AND tipo_cnt = :tipocnt";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':tipocnt', $tipocnt);			
	$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
	$stmt->execute();		

	// Atualiza o status apenas do registro publicado
	$sql = "UPDATE tbl_cnt_usr SET status_cnt = :status WHERE id_cnt = :idcnt ";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':status', $status);	
	$stmt->bindParam(':idcnt', $idcnt, PDO::PARAM_INT);
	$stmt->execute();

	// Query SQL para selecionar valor de redir_cli
	$sql = "SELECT redir_cli, nome_cli FROM tbl_cli WHERE id_cli = :idcli";
	$stmt = $PDO->prepare($sql);
	$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
	$stmt->execute();
	$user = $stmt->fetch(PDO::FETCH_ASSOC);

		 
		// Monta a url de redirect 
		$nome = $user['nome_cli'];		 
		$nameNoSpc = retiraAcentos(utf8_decode($nome));
		$NomeTxt = $nameNoSpc.'-'.$tipocnt.'-'.$user['redir_cli'];
        $quebra = chr(13).chr(10); //essa é a quebra de linha

        $headertxt = '<?php'.$quebra;
        $headertxt .= 'header( "Expires: Sat, 26 Jul 1997 05:00:00 GMT" );'.$quebra;
        $headertxt .= 'header( "Last-Modified: gmdate( "D, d M Y H:i:s",time()+60*60*8 ) GMT" );'.$quebra;
        $headertxt .= 'header( "Cache-Control: no-store, no-cache, must-revalidate" );'.$quebra;
        $headertxt .= 'header( "Cache-Control: post-check=0, pre-check=0", false );'.$quebra;
        $headertxt .= 'header( "Pragma: no-cache" );'.$quebra;
        $headertxt .= 'header( "Location: https://www.holodroide.com/sistema_bares/uploader/redirect/'.$NomeTxt.'" );'.$quebra;
        $headertxt .= '?>';

		// Rescreve o arquivo php de redirect
		$file = fopen('uploaders/redirect/'.$NomeTxt, 'w');
		fwrite($file, $headertxt);
		fclose($file);

		// Se a qyery foi executada, exibe mensagem e volta para página anterior
		if ($stmt->execute()){
		      echo "<script>
	          alert('OK, LUKE SKYWALKER... O CONTEÚDO FOI PUBLICADO!');
	          window.history.back()
			  </script>";
			  exit;

		// Se a query não foi executada, exibe mensagem de erro e volta para página anterior
		} else {

		    echo "<script>
		          alert('ERRO: ".print_r($stmt->errorInfo())."');
		          window.history.back()
		         </script>";
		    exit;

		}
