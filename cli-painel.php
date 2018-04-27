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

$idcli = isset($_GET['idcli']) ? $_GET['idcli'] : null;


// Abre a conexão
$PDO = db_connect();
 
// Uso da função COUNT do SQL para contar o total de registros
$sql_count = "SELECT COUNT(*) AS total FROM tbl_cli";
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();

// Define variável com array gerado pela query
$total = $stmt_count->fetchColumn();
 
// Sql query para selecionar os registros na tabela
$sql = "SELECT id_cli, empresa_cli, nome_cli, email_cli, senha_cli, imglogo_cli, tipo_txt, tipo_img, tipo_vid, redir_cli, usr_cli FROM tbl_cli ORDER BY nome_cli ASC";
$stmt1 = $PDO->prepare($sql);
$stmt1->execute();

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
          <div class="col-md-12" style="text-align:LEFT;margin:50px 0 10px 0;"><img src="../images/logo_holodroide_sistema.png" width="300" height="32" alt=""/><br />
              <h4>ADMIN - LISTAR CLIENTES</h4><br>
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
            TOTAL DE CLIENTES CADASTRADOS: <?php echo $total ?></strong>
          </div>
      </div>  

      <?php
       // Se a variável $total for maior que 0  
       if ($total > 0):
       // Loop para os registros da query com array $user 
       while ($user = $stmt1->fetch(PDO::FETCH_ASSOC)):  
      ?>


      <div class="row" style="border-bottom:1px dashed #000;padding:10px;">
         
          <!-- Menu lateral / Botões -->
          <div class="col-md-2" style="text-align:center;">
            <img src="http://holodroide.com/sistema/cliente/arquivos/<? echo $user['imglogo_cli'] ?>" width="100"><br><br>
            <a href="cli-edit-form.php?idcli=<?php echo $user['id_cli'] ?>" class="btn btn-success" style="width:150px;margin:5px;" role="button">ALTERAR</a>
            <a href="cli-delete.php?idcli=<?php echo $user['id_cli'] ?>" onclick="return confirm('Tem certeza de que deseja remover?');" class="btn btn-danger" style="width:150px;margin:5px;" role="button">EXCLUIR</a>  
            <a href="cli-pw-form.php?idcli=<?php echo $user['id_cli'] ?>" class="btn btn-warning" style="width:150px;margin:5px;" role="button">ALTERAR SENHA</a> 
            <a href="cli-usr-painel.php?idcli=<?php echo $user['id_cli'] ?>" class="btn btn-info" style="width:150px;margin:5px;" role="button">LISTAR USUÁRIOS</a> 
            
            <!-- <a href="cli-relatorio-conteudo.php?idcli=<?php echo $user['id_cli'] ?>&nomecli=<?php echo $user['nome_cli'] ?>" class="btn btn-info" style="width:150px;margin:5px;" role="button">CONTEÚDO</a> -->                          
          </div>  

      
          <!-- Informações do cliente -->
          <div class="col-md-10" style="text-align:left;">
            <strong>ID:</strong> <? echo $user['id_cli'] ?><br />
            <strong>EMPRESA:</strong> <? echo $user['empresa_cli'] ?><br />            
            <strong>USUÁRIO:</strong> <? echo $user['nome_cli'] ?><br />
            <strong>EMAIL:</strong> <? echo $user['email_cli'] ?><br />
            <strong>ARQUIVO LOGO:</strong> <? echo $user['imglogo_cli'] ?><br /><br>

          <?php
          $sql1 = "SELECT * FROM tbl_usr WHERE id_usr = :usrcli";
          $stmt = $PDO->prepare($sql1);
          $stmt->bindParam(':usrcli', $user['usr_cli'], PDO::PARAM_INT);
          $stmt->execute();          
          $result = $stmt->fetch(PDO::FETCH_ASSOC);
            // Monta a url de redirect 
            $nome = $user['nome_cli'];     
            $nameNoSpc = retiraAcentos(utf8_decode($nome));

          
          // Condicionais para exibir apenas os redirect configurados para o cliente
          if($user['tipo_txt'] !== null){ 

            $NomeTxt = $nameNoSpc.'-txt-'.$result['redir_usr'];
            echo '<strong>Texto Redirect</strong><br>
            <h5><a href="https://www.holodroide.com/sistema_bares/uploaders/redirect/'.$NomeTxt.'" target="_blanck">https://www.holodroide.com/sistema_bares/uploaders/redirect/'.$NomeTxt.'</a></h5><br>';
          }

          if($user['tipo_img'] !== null){ 
            $NomeTxt = $nameNoSpc.'-img-'.$result['redir_usr'];
            echo '<strong>Foto Redirect</strong><br>
            <h5><a href="https://www.holodroide.com/sistema_bares/uploaders/redirect/'.$NomeTxt.'" target="_blanck">https://www.holodroide.com/sistema_bares/uploaders/redirect/'.$NomeTxt.'</a></h5><br>';
          }

          if($user['tipo_vid'] !== null){ 
            $NomeTxt = $nameNoSpc.'-vid-'.$result['redir_usr'];
            echo '<strong>Vídeo Redirect</strong><br>
            <h5><a href="https://www.holodroide.com/sistema_bares/uploaders/redirect/'.$NomeTxt.'" target="_blanck">https://www.holodroide.com/sistema_bares/uploaders/redirect/'.$NomeTxt.'</a></h5><br>';
          }
         
          ?>

          </div>

      </div>  

      <?php
       endwhile;
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
