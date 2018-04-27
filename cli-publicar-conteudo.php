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
$idcont = isset($_GET['idcont']) ? (int) $_GET['idcont'] : null;
$idcli = isset($_GET['idcli']) ? (int) $_GET['idcli'] : null;
$status = isset($_GET['status']) ? $_GET['status'] : null;
$tipocont = isset($_GET['tipocont']) ? $_GET['tipocont'] : null;

		// Atualiza todosos registros do cliente no BD para status N
		$PDO = db_connect();
		$sql = "UPDATE tbl_conteudo_usr SET status_cont = 'N' WHERE id_cli = :idcli AND tipo_cont = :tipocont";
		$stmt = $PDO->prepare($sql);
			$stmt->bindParam(':tipocont', $tipocont);			
		$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
		$stmt->execute();		


		// Atualiza o BD, menos a senha
		$sql = "UPDATE tbl_conteudo_usr SET status_cont = :status WHERE id_cont = :idcont ";
		$stmt = $PDO->prepare($sql);
			$stmt->bindParam(':status', $status);	
		$stmt->bindParam(':idcont', $idcont, PDO::PARAM_INT);





			function retiraAcentos($string){
			   $acentos  =  'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
			   $sem_acentos  =  'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
			   $string = strtolower(strtr($string, utf8_decode($acentos), $sem_acentos));
			   $string = str_replace(" ","-",$string);
			   return utf8_decode($string);
			}
			 
			$redirCli = uniqid().'.php';
			$nameNoSpc   =   retiraAcentos(utf8_decode($name));
			$NomeTxt = $nameNoSpc.'-txt-'.$redirCli;
			$NomeImg = $nameNoSpc.'-img-'.$redirCli;
			$NomeVid = $nameNoSpc.'-vid-'.$redirCli;
			
			$text = "";

			$file = fopen('arquivos/'.$NomeTxt, 'a');
			fwrite($file, $text);
			fclose($file);

			$file = fopen('arquivos/'.$NomeImg, 'a');
			fwrite($file, $text);
			fclose($file);

			$file = fopen('arquivos/'.$NomeVid, 'a');
			fwrite($file, $text);
			fclose($file);





		if ($stmt->execute()){
		      echo "<script>
	          alert('Status atualizado com sucesso!');
	          window.history.back()
			  </script>";

	    exit;

		} else {

			    echo "Erro ao cadastrar";
			    print_r($stmt->errorInfo());

		}
