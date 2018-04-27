<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Fas o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';

header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
 
// Recebe os dados do formulário e define as variáveis
$idcli = $_SESSION['cli_id'];    
 
// Validação simples. Confere se a variável tem algum valor
if (empty($idcli))
{
  echo '<script type="text/javascript">
  alert("REGISTRO NÂO ENCONTRADO!");
  window.history.back()
  </script>';
  exit;
}
 
// Executa query para selecionar os registros em tbl_cli
$PDO = db_connect();
$sql = "SELECT * FROM tbl_cli WHERE id_cli = :idcli";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
$stmt->execute();

// Define variável com array resultado da query 
$user = $stmt->fetch(PDO::FETCH_ASSOC);
 
// Se o array gerado pela query for vazio, exibe msg e volta para página anterior
if (!is_array($user))
{
  echo '<script type="text/javascript">
        alert("NENHUM REGISTRO ENCONTRADO!");
        window.history.back()
      </script>';
  exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>

      <title>HOLODROIDE ADMIN</title>        

      <meta charset="utf-8">

      <!-- ===================== Mobile Specific ============================= -->
      <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

      <!-- ==================== BootStrap ====================== -->   
      <!-- Latest compiled and minified CSS -->
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>        
      <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
      
      <!-- Custom CSS -->
    <link href="../css/holodroide.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">
    
    <!-- Custom fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="../css/animate.min.css" rel="stylesheet" type="text/css">

  </head>

     <div class="container" style="margin-bottom:200px;">

        <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas -->
        <div class="row">
          <div class="col-md-12" style="text-align:left;margin:50px 0 10px 0;"><img src="../../images/logo_holodroide_sistema.png" width="300" height="32" alt=""/><br />
              <h4>CLIENTE - ALTERAR CADASTRO</h4><br>
              <img src="https://holodroide.com/sistema/cliente/arquivos/<? echo $user['imglogo_cli'] ?>" style="height:40px;"><br>
              EMPRESA: <a href="#"><?php echo $user['empresa_cli']; ?></a>
          </div>
        </div>      


        <!-- Menu topo horizontal Início -->
        
        <div class="row">
            <div class="col-md-12" style="text-align:left;margin:20px 0 10px 0; padding:0;">
                <div style="margin:0 auto;text-align:center;border:1px;max-width:800px;display: inline">
                    
                    
                    <div style="display: inline">
                        <a href="index.php" class="btn btn-success" role="button" aria-pressed="true">INICIAL</a>
                    </div>
                    

                    
                    <div class="dropdown" style="display: inline">
		<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    CADASTRO
    <span class="caret"></span>
  		</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li><a href="cli-edit-form.php?idcli=<?php echo $idcli ?>">Alterar Cadastro</a></li>
					<li role="separator" class="divider"></li>
                    <li><a href="cli-pw-form.php?idcli=<?php echo $idcli ?>">Alterar Senha</a></li>
				</ul>
	</div>
    
    
    
    
    <div class="dropdown" style="display: inline">
		<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    USUÁRIOS
    <span class="caret"></span>
  		</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
					<li><a href="usr-painel.php">Listar</a></li>
					<li role="separator" class="divider"></li>
                    <li><a href="usr-add-form.php">Inserir</a></li>
				</ul>
	</div>
                    


                    <div style="display: inline">
                     <a href="cli-logout.php" class="btn btn-danger" role="button" aria-pressed="true">LOGOUT</a>    
                    </div>
                    
                    
                </div>
            </div>  

        </div>
        
        <!-- Menu topo horizontal Início -->



        <div class="row">
          <div class="col-md-12" style="text-align:left;margin:0 0 30px 0;">
           <br><br><h5>Altere os dados desejados e clique no botão "ALTERAR"</h5>
          </div>
      </div> 

      <!-- formulário editaar cadastro cliente -->
      <form action="cli-edit.php"  enctype="multipart/form-data"  method="post" name="form1" id="form1">

      
      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Empresa:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <input name="empresa_cli" type="text" id="empresa_cli" size="50" value="<?php echo $user['empresa_cli'] ?>">
          </div>          
      </div>   
      <div class="row">             
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Nome:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <input name="nome_cli" type="text" id="nome_cli" size="50" value="<?php echo $user['nome_cli'] ?>">
          </div>          
      </div>  

      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Email:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <input name="email_cli" type="text" id="email_cli" size="50" value="<?php echo $user['email_cli'] ?>">
          </div>          
      </div>  

      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Conteúdo:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">
         
          <?php
          
          if($user['tipo_txt']){ 
            echo 'TEXTO | ';
          }

          if($user['tipo_img']){ 
            echo 'FOTO | ';
          }

          if($user['tipo_vid']){ 
            echo 'VÍDEO';
          }
         
          ?>
          <p style="font-size:0.800em;"><br>
          Obs: Para alterar o tipo de conteúdo contratado, <a href="#">solicite ao suporte</a>.</p>
          
          </div>          
      </div> 

      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Logo:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <input type="file" name="imglogo_cli">
            <br/><br/>
          </div> 
      </div> 

      <div class="row">
          <div class="col-md-2" style="text-align:right;">        

          </div>        
          <div class="col-md-10" style="text-align:left;">
            <img src="http://holodroide.com/sistema/cliente/arquivos/<? echo $user['imglogo_cli'] ?>">
          </div>                      
      </div> 


      <div class="row">
          <div class="col-md-2" style="text-align:right;">        

          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;"> 
            <br/><br/>
            <input type="hidden" name="idusr" value="<?php echo $user['usr_cli'] ?>">       
            <input type="button" name="button" id="button" class="btn btn-danger" value="CANCELAR" onclick="window.history.back()" />
            <input type="submit" name="button" id="button"  class="btn btn-success"  value="ALTERAR" />
          </div>          
      </div>  
      </form>
    </div> 
 
    </body>
</html>