<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Fas o Hash de senha 
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
 
    <body>
         <div class="container">

            <!-- Se usuário está logado no sistema, exibe menu -->
            <?php if (AdmIsLoggedIn()): ?>  
                      
            <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas -->
            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:200px 0 50px 0;"><img src="../images/logo_holodroide_sistema.png" width="300" height="32" alt=""/><br />
                   <br>
				 <h4>ADMIN - PAINEL DE CONTROLE</h4>
                </div>
            </div>
            
            

            <!-- Menu topo horizontal Início -->
            
            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:20px 0 10px 0;">
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
                <div class="col-md-12" style="text-align:center;;margin:30px 0 10px 0;">
                    <h4>Olá, <?php echo $_SESSION['adm_name']; ?>.</h4>
                </div>
           </div>   

            <!-- Se usuário não está logado no sistema, exibe formulário de login. -->
            <?php else: ?>

            <!-- Formulário de login de administrador -->
            <div class="row">
                <div class="col-md-12" style="text-align:center;margin:50px 0 50px 0;">
                    <img src="https://www.holodroide.com/images/logo_holodroide_sistema.png" width="300px" height="34px"><br />
                    <h3>LOGIN ADMINISTRADOR</h3>
                </div>
            </div>            

             <div class="row">
                <div class="col-md-12" style="text-align:center;margin:50px 0 50px 0;">
                    <form action="adm-login.php" method="post">
                       EMAIL
                        <br>
                        <input type="text" name="email" id="email" style="width:100%; max-width:270px;">
             
                        <br><br>
             
                        SENHA
                        <br>
                        <input type="password" name="password" id="password" style="width:100%; max-width:270px;">
             
                        <br><br>
             
                        <input type="submit" value="ENTRAR" class="btn btn-danger" style="width:100%; max-width:270px;">
                    </form>
                </div>
            </div>

            <?php endif; ?>

        </div>
 
    </body>
</html>