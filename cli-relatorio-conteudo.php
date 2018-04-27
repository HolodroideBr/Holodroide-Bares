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

// pega o ID da URL
$idcli = isset($_GET['idcli']) ? (int) $_GET['idcli'] : null;
$nomecli = isset($_GET['nomecli']) ? $_GET['nomecli'] : null;
 
// valida o ID
if (empty($idcli))
{
    echo "<script>
          alert('ENGENHARIA... CHECOV... QUAL O PROBLEMA? PRECISAMOS DE UM ID!');
          window.history.back()
      </script>";
    exit;
}

// abre a conexão
$PDO = db_connect();
 
// SQL para contar o total de registros
// A biblioteca PDO possui o método rowCount(), mas ele pode ser impreciso.
// É recomendável usar a função COUNT da SQL
$sql_count = "SELECT COUNT(*) AS total FROM tbl_cnt_usr WHERE id_cli = $idcli";
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();


$total = $stmt_count->fetchColumn();
 
//$usrName = $stmt->fetch(PDO::FETCH_ASSOC)
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

      <script>
      function alertNoDel() {
          alert("CONTEÚDO PUBLICADO NÃO PODE SER DELETADO, NÃO SABE?! ");
      }

      function alertPub() {
          alert("ESSE CONTEÚDO JÁ ESTÁ BUBLICADO. ESCOLHA OUTRO!");
      }     
      </script>

  </head>

  <body>

     <div class="container" style="margin-bottom:200px;">

      <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas -->
      <div class="row">
          <div class="col-md-12" style="text-align:LEFT;margin:50px 0 10px 0;"><img src="../images/logo_holodroide_sistema.png" width="300" height="32" alt=""/><br />
              <h4>ADMIN - LISTAR CONTEÚDO CLIENTE</h4><br>
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
                        
                        
                        
                        
                        <div style="display: inline">
                            <a href="cli-painel.php" class="btn btn-success" role="button">CLIENTES</a>           
                        </div>
                        
                        
                        
                        
                        
                       <!-- <div class="dropdown" style="display: inline">
		<button class="btn btn-success dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
    CLIENTES
    <span class="caret"></span>
  		</button>
				<ul class="dropdown-menu" aria-labelledby="dropdownMenu2">
					<li><a href="cli-painel.php">Listar</a></li>
					<li role="separator" class="divider"></li>
                    <li><a href="cli-add-form.php">Inserir</a></li>
				</ul>
						</div> -->
                        
                        
                        
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
          <div class="col-md-12" style="text-align:left;margin:0 0 20px 0;">
            <strong>CLIENTE: </strong><?php echo strtoupper($nomecli) ?><br>
            <strong>TOTAL DE REGISTROS PARA O CLIENTE: </strong><?php echo $total ?>
          </div>

      </div>  

 

      <?php  
      if ($total > 0):

      // Query SQL para selecionar os registros tipo TXT
      // $sql1 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_usr.id_cli = $idcli AND tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'txt' ORDER BY tbl_cnt_usr.id_cnt DESC";
      $sql1 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'txt' ORDER BY tbl_cnt_usr.id_cnt DESC";
      $stmt = $PDO->prepare($sql1);
      $stmt->execute();
      $total1 = $stmt->fetchColumn();
      if ($total1 > 0):
        ?>
       <div class="row" style="border-bottom:0px;margin-bottom:10px;background-color:#ccc;">
          <div class="col-md-12" style="text-align:center;">
                  <h3><strong>TEXTOS</strong></h3>
                </div>          
      </div> 

      <?php
      // Loop para exibir conteúdo tipo TXT
      while ($user1 = $stmt->fetch(PDO::FETCH_ASSOC)):  
      ?>

      <div class="row" style="border-bottom:1px dashed #000;padding:10px;">
          <div class="col-md-2" style="text-align:left;">
            <h5><? echo $user1['data_cnt'] ?></h5>
          </div>  
          <div class="col-md-2" style="text-align:left;">
            <h5><? echo $user1['nome_usr'] ?></h5><br />
            <h5><? echo $user1['email_usr'] ?></h5>
          </div>                
          <div class="col-md-6" style="text-align:left;">

                <h5><?php

                  echo $user1['text_cnt'];

                ?></h5>
                
          </div>
          <div class="col-md-2" style="text-align:left;">
            <?php
              if ($user1['status_cnt'] == 'N') {
                echo '<a href="cli-pub-cnt.php?status=S&idcnt='.$user1['id_cnt'].'&idcli='.$user1['id_cli'].'&tipocnt='.$user1['tipo_cnt'].'" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button">PUBLICAR</a>';                
                echo '<br><a href="cli-delete-cnt.php?idcnt='.$user1['id_cnt'].'&idcli='.$user1['id_cli'].'&nomecli='.$nomecli.'" class="btn btn-danger"  style="width:150px;padding:5px;margin:2px;" role="button">DELETAR</a>';                              
              } else {
                echo '<a href="#" class="btn btn-primary" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                echo '<br><a href="#" class="btn btn-danger" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
              }
            ?>  
          </div> 
      </div>  

      <?php
       endwhile;
       endif;

      // Query SQL para selecionar os registros tipo IMG
      // $sql2 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_usr.id_cli = $idcli AND tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'img'  ORDER BY tbl_cnt_usr.id_cnt DESC";
      $sql2 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'img'  ORDER BY tbl_cnt_usr.id_cnt DESC";
      $stmt = $PDO->prepare($sql2);
      $stmt->execute();
      $total2 = $stmt->fetchColumn();
      if ($total2 > 0):  
      ?>
      
          
       <div class="row" style="border-bottom:0px;margin-bottom:10px;background-color:#ccc;">
          <div class="col-md-12" style="text-align:center;">
            <h3><strong>FOTOS</strong></h3>
          </div>          
      </div> 
      <?php  
      // Loop para exibir conteúdo tipo IMG
      while ($user2 = $stmt->fetch(PDO::FETCH_ASSOC)): 
       ?>
      <div class="row" style="border-bottom:1px dashed #000;padding:10px;">
          <div class="col-md-2" style="text-align:left;">
            <h5><? echo $user2['data_cnt'] ?></h5>
          </div>  
          <div class="col-md-2" style="text-align:left;">
            <h5><? echo $user2['nome_usr'] ?></h5><br />
            <h5><? echo $user2['email_usr'] ?></h5>
          </div>                
          <div class="col-md-6" style="text-align:left;">

                <?php

                  echo '<img src="http://holodroide.com/sistema/uploaders/foto/fotos/'.$user2['text_cnt'].'" width="270px">';

                ?>
                
          </div>
          <div class="col-md-2" style="text-align:left;">
            <?php
              if ($user2['status_cnt'] == 'N') {
                echo '<a href="cli-pub-cnt.php?status=S&idcnt='.$user2['id_cnt'].'&idcli='.$user2['id_cli'].'&tipocnt='.$user2['tipo_cnt'].'" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button">PUBLICAR</a>';                
                echo '<br><a href="cli-delete-cnt.php?idcnt='.$user2['id_cnt'].'&idcli='.$user2['id_cli'].'&nomecli='.$nomecli.'" class="btn btn-danger"  style="width:150px;padding:5px;margin:2px;" role="button">DELETAR</a>';                              
              } else {
                echo '<a href="#" class="btn btn-primary" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                echo '<br><a href="#" class="btn btn-danger" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
              }
            ?>  
          </div> 
      </div>  

      <?php
      endwhile;
      endif;

      // Query SQL para selecionar os registros tipo VID
      // $sql3 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_usr.id_cli = $idcli AND tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'vid'  ORDER BY tbl_cnt_usr.id_cnt DESC";
      $sql3 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'vid'  ORDER BY tbl_cnt_usr.id_cnt DESC";
      $stmt = $PDO->prepare($sql3);
      $stmt->execute();
      $total31 = $stmt->fetchColumn();
      if ($total31 > 0):  
      ?>
       <div class="row" style="border-bottom:0px;margin-bottom:10px;background-color:#ccc;">
              <div class="col-md-12" style="text-align:center;">
                <h3><strong>VÍDEOS</strong></h3>
              </div>          
          </div>  
      <?php
      // Loop para exibir conteúdo tipo VID
      while ($user3 = $stmt->fetch(PDO::FETCH_ASSOC)): 
       ?>
      <div class="row" style="border-bottom:1px dashed #000;padding:10px;">
          <div class="col-md-2" style="text-align:left;">
            <h5><? echo $user3['data_cnt'] ?></h5>
          </div>  
          <div class="col-md-2" style="text-align:left;">
            <h5><? echo $user3['nome_usr'] ?></h5><br />
            <h5><? echo $user3['email_usr'] ?></h5>
          </div>                
          <div class="col-md-6" style="text-align:left;">

                <?php
                echo '<video width="270" controls="controls">';
                echo '<source src="uploaders/video/converted_videos/'.$user3['text_cnt'].'" type="video/mp4">';
                echo '<object data="" width="270">';
                echo '<embed width="270" src="uploaders/video/converted_videos/'.$user3['text_cnt'].'">';
                echo '</object>';
                ?>
                
          </div>
          <div class="col-md-2" style="text-align:left;">
            <?php
              if ($user3['status_cnt'] == 'N') {
                echo '<a href="cli-pub-cnt.php?status=S&idcnt='.$user3['id_cnt'].'&idcli='.$user3['id_cli'].'&tipocnt='.$user3['tipo_cnt'].'" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button">PUBLICAR</a>';                
                echo '<br><a href="cli-delete-cnt.php?idcnt='.$user3['id_cnt'].'&idcli='.$user3['id_cli'].'&nomecli='.$nomecli.'" class="btn btn-danger"  style="width:150px;padding:5px;margin:2px;" role="button">DELETAR</a>';                              
              } else {
                echo '<a href="#" class="btn btn-primary" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                echo '<br><a href="#" class="btn btn-danger" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
              }
            ?>  
          </div> 
      </div>  

      <?php
      endwhile;
      endif;
      else:
      ?>
 
      <div class="row" style="border-bottom:1px dashed #000;padding:10px;background-color:#ccc;">
          <div class="col-md-12" style="text-align:center;">
          <h4>NENHUM CONTEÚDO REGISTRADO!</h4>
          </div>          
      </div>

      <div class="row" style="padding:10px;">
          <div class="col-md-12" style="text-align:center;">
            <input type="button" name="button" id="button" class="btn" style="background-color: #ddd;margin:2px;" value="VOLTAR" onclick="window.history.back()" />                               
          </div>          
      </div>            
 
      <?php endif; ?>

    </div>

</body>
</html>
