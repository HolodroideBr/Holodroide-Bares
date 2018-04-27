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

// Abre a conexão com MySql
$PDO = db_connect();
 
// SQL para contar o total de registros
// A biblioteca PDO possui o método rowCount(), mas ele pode ser impreciso.
// É recomendável usar a função COUNT da SQL
$sql_count = "SELECT COUNT(*) AS total FROM tbl_adm";
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();
$total = $stmt_count->fetchColumn();
 
// Executa query para selecionar os registros
$sql = "SELECT id_adm, nome_adm, email_adm, senha_adm FROM tbl_adm ORDER BY nome_adm ASC";
$stmt = $PDO->prepare($sql);
$stmt->execute();
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

  <body>

   <div class="container" style="margin-bottom:200px;">

      <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas -->
      <div class="row">
          <div class="col-md-12" style="text-align:LEFT;margin:50px 0 30px 0;"><img src="../images/logo_holodroide_sistema.png" width="300" height="32" alt=""/><br />
              <h4>ADMIN - LISTAR ADMINISTRADORES</h4><br>
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
            <h4>Total de administradores cadastrados: <?php echo $total ?></h4>
          </div>
      </div>  

      <?php  
       // Se a variável $total for maior que 0 (ou seja, NÃO vazio), executa o loop com array $user
       if ($total > 0):
       while ($user = $stmt->fetch(PDO::FETCH_ASSOC)):  
      ?>

      <div class="row" style="border-bottom:1px dashed #000;padding:10px;">
         
          <div class="col-md-2" style="text-align:right;">
            <a href="adm-edit-form.php?idadm=<?php echo $user['id_adm'] ?>" class="btn btn-success" style="width:150px;margin:2px;" role="button">ALTERAR</a>
            
            <a href="adm-delete.php?idadm=<?php echo $user['id_adm'] ?>" onclick="return confirm('Tem certeza de que deseja remover?');" class="btn btn-danger" style="width:150px;margin:5px;" role="button">EXCLUIR</a>  
            
            <a href="adm-pw-form.php?idadm=<?php echo $user['id_adm'] ?>" class="btn btn-warning" style="width:150px;margin:5px;" role="button">ALTERAR SENHA</a>  
            
          </div>        
          <div class="col-md-10" style="text-align:left;">
            <strong>ID:</strong> <? echo $user['id_adm'] ?><br />
            <strong>NOME:</strong> <? echo $user['nome_adm'] ?><br />
            <strong>EMAIL:</strong> <? echo $user['email_adm'] ?><br />
          </div>
      </div>  

      <?php
       endwhile;

       // Se $ total for vazio, exibe mensagem.
       else:
      ?>
 
       <div class="row">
          <div class="col-md-12" style="text-align:left;">
            <p>Nenhum administrador registrado.</p>
          </div>
      </div>  
 
      <?php endif; ?>

    </div>

</body>
</html>
