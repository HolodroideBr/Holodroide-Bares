<?php
session_start();
 
// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Faz o Hash de senha 
require_once 'include/init.php';

header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );
?>
<!doctype html>
<html>
    <head>

        <title>HOLODROIDE CLIENTE</title>        

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
         <div class="container">

            <!-- Se usuário está logado no sistema, exibe menu -->
            <?php 
            if (CliIsLoggedIn()):  
            $idcli = $_SESSION['cli_id'];

            // abre a conexão
            $PDO = db_connect();
                          
            // SQL para selecionar os registros
            $sql = "SELECT * FROM tbl_cli WHERE id_cli = $idcli";
            $stmt = $PDO->prepare($sql);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC)

            ?>  
                      

            <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas) -->
            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:200px 0 50px 0;"><img src="../../images/logo_holodroide_sistema.png" width="300" height="32" alt=""/><br /><br>

                    <h4>CLIENTE - PAINEL DE CONTROLE</h4>
                </div>
            </div>

            <!-- Mneu top horizontal -->
            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:20px 0 10px 0;">
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

            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:10px 0 10px 0;">
                    <div style="max-width:200px;margin:0 auto;">
                        <img src="http://holodroide.com/sistema/cliente/arquivos/<? echo $user['imglogo_cli'] ?>" style="width:100%;"> <br>
                        <!-- h4>USUÁRIO: <?php //echo $_SESSION['cli_name']; ?></h4 -->
                    </div>                   
                </div>
            </div>



            <?php else: ?>

            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:50px 0 50px 0;">
                    <img src="https://www.holodroide.com/images/logo_holodroide_sistema.png" width="300px" height="34px"><br />
                    <h3>LOGIN CLIENTES</h3>
                </div>
            </div>            

             <div class="row">
                <div class="col-md-12" style="text-align:center;margin:50px 0 50px 0;">
                    <form action="cli-login.php" method="post">
                        EMAIL
                        <br>
                        <input type="text" name="email" id="email" style="width:100%; max-width:270px;">
             
                        <br><br>
             
                        SENHA
                        <br>
                        <input type="password" name="password" id="password" style="width:100%; max-width:270px;">
             
                        <br><br>
             
                        <input type="submit" value="ENTRAR" class="btn btn-danger"  style="width:100%; max-width:270px;">
                    </form>
                </div>
            </div>

            <?php endif; ?>

        </div>
 
    </body>
</html>