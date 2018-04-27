<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Faz o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';

header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
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

<body>

     <div class="container" style="margin-bottom:200px;">

        <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas -->
        <div class="row">
          <div class="col-md-12" style="text-align:left;margin:50px 0 10px 0;">
              <img src="https://www.holodroide.com/images/logo_holodroide_sistema.png" width="300px" height="34px"><br />
              <h4>CLIENTE - ALTERAR CADASTRO</h4><br>
              <img src="https://holodroide.com/sistema/cliente/arquivos/<? echo $_SESSION['cli_img']; ?>" style="height:40px;"><br>
              USUÁRIO: <a href="#"><?php echo $_SESSION['cli_name']; ?></a>
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
            <h5>Preencha o formulário com os dados do novo usuário e clique no botão "CADASTRAR"</h5>
          </div>
      </div> 

      <form action="usr-add.php" method="post"  name="form-user" id="form-cli">
      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Nome:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <input name="nome_usr" type="text" id="nome_usr" size="50" value="">
          </div>          
      </div>  

      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Email:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <input name="email_usr" type="text" id="email_usr" size="50" value="">
          </div>          
      </div>  

      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Senha:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <input name="senha_usr" type="text" id="senha_usr" size="50" value="">
          </div>          
      </div>  
      
      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Cliente:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
           <? echo $_SESSION['cli_name']; ?>
            </select>
          </div>          
      </div> 

      <div class="row">
          <div class="col-md-2" style="text-align:right;">        

          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">  
            <input type="button" name="button" id="button" class="btn btn-danger" value="CANCELAR" onclick="window.history.back()" />                
            <input type="submit" name="button" id="button"  class="btn btn-success"  value="CADASTRAR" />
          </div>          
      </div>  
      </form>
    </div>

</body>
</html>
