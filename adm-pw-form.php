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
$idadm = isset($_GET['idadm']) ? (int) $_GET['idadm'] : null;
 
// Validação simples. Confere se a variável tem algum valor
if (empty($idadm))
{
    echo "ID para alteração não definido";
    exit;
}
 
// Executa query para buscar os dados do usuário do administrador
$PDO = db_connect();
$sql = "SELECT nome_adm, email_adm, senha_adm FROM tbl_adm WHERE id_adm = :idadm";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':idadm', $idadm, PDO::PARAM_INT);
$stmt->execute();

// Define variável com o array  resultado da query
$user = $stmt->fetch(PDO::FETCH_ASSOC);
 
// Se a query for executada, redireciona para o painel admin  
if (!is_array($user))
{
    echo "<script>
          alert('NENHUM REGISTRO ENCONTRADO PARA ESSE ID!');
          window.history.back()
      </script>";
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
    <link href="css/holodroide.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">
    
    <!-- Custom fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="css/animate.min.css" rel="stylesheet" type="text/css">

  </head>

     <div class="container" style="margin-bottom:200px;">
        <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas -->
        <div class="row">
          <div class="col-md-12" style="text-align:LEFT;margin:50px 0 30px 0;">
              <img src="https://www.holodroide.com/images/logo_holodroide_sistema.png" width="300px" height="34px"><br />
              <h4>ADMIN - ALTERAR SENHA</h4><br>
              Olá, <?php echo $_SESSION['adm_name']; ?>
          </div>
      </div>





            <!-- Menu topo horizontal Início -->
            
            <div class="row">
                <div class="col-md-12" style="text-align:left;margin:20px 0 10px 0;">
                    <div style="margin:0 auto;text-align:center;border:1px;max-width:800px;display: inline">
                    
                        <div style="display: inline">
                            <a href="index.php" class="btn btn-success" role="button">INICIAL</a>           
                        </div>
                        
                        
                        
                        <div class="dropdown" style="display: inline">
		<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    ADMINISTRADORES
    <span class="caret"></span>
  		</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<li><a href="adm-painel.php">Listar</a></li>
					<li role="separator" class="divider"></li>
                    <li><a href="adm-add-form.php">Inserir</a></li>
				</ul>
						</div>
                        
                        
                        
                        
                        <div class="dropdown" style="display: inline">
		<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    CLIENTES
    <span class="caret"></span>
  		</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<li><a href="cli-painel.php">Listar</a></li>
					<li role="separator" class="divider"></li>
                    <li><a href="cli-add-form.php">Inserir</a></li>
				</ul>
						</div>
                        
                        
                        
                        <div class="dropdown" style="display: inline">
		<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    USUÁRIOS
    <span class="caret"></span>
  		</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<li><a href="usr-painel.php">Listar</a></li>
					<li role="separator" class="divider"></li>
                    <li><a href="usr-add-form.php">Inserir</a></li>
				</ul>
						</div>

                        
                        <div style="display: inline">
                     <a href="adm-logout.php" class="btn btn-danger" role="button" aria-pressed="true">LOGOUT</a>    
                    </div>


                    </div>
                </div>  

            </div>
            
            <!-- Menu topo horizontal Fim -->







      <div class="row">
          <div class="col-md-12" style="text-align:left;margin:0 0 30px 0;">
            <h5>Digite a nova senha para o administrador e clique no botão "ALTERAR SENHA"</h5>
          </div>
      </div> 

      <form action="adm-pw-new.php" method="post" name="adm-new-pw" id="adm-new-pw">
      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Nome:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <?php echo $user['nome_adm'] ?>
          </div>          
      </div>          
      <div class="row">
          <div class="col-md-2" style="text-align:right;padding:5px;">        
            Nova Senha:
          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;">        
            <input name="senha_adm" type="text" id="senha_adm" size="40" value="">
          </div>          
      </div>  

      <div class="row">
          <div class="col-md-2" style="text-align:right;">        

          </div>
          <div class="col-md-10" style="text-align:left;padding:5px;"> 
            <input type="hidden" name="idadm" value="<?php echo $idadm ?>"> 
            <input type="button" name="button" id="button" class="btn btn-danger" value="CANCELAR" onclick="window.history.back()" />      
            <input type="submit" name="button" id="button"  class="btn btn-warning" value="ALTERAR SENHA" />
          </div>          
      </div>  
      </form>
    </div> 
 
    </body>
</html>