<?php
session_start();

// Inclui conexão com BR MySql
// Confere se usuário  está logado (Administrador, Cliente ou Usuário)
// Faz o Hash de senha 
require_once 'include/init.php';

// Faz a validação da sessão do cliente e atribui TRUE ou FALSE na variável
// Se TRUE, exibe menu. Se FALSE, exibe formulário de login
require 'include/check.php';

// pega o ID da URL
$idusr = isset($_GET['idusr']) ? (int) $_GET['idusr'] : null;
$idcli = $_SESSION['cli_id'];
$nomeusr = isset($_GET['nomeusr']) ? $_GET['nomeusr'] : null;
$nomecli = $_SESSION['cli_name'];
 
// valida o ID
if (empty($idusr))
{
    echo '<script type="text/javascript">
    alert("ROBIN, SUA ANTA... CADÊ O ID QUE DEVIA ESTAR AQUI?!");
    window.history.back()
    </script>';

        exit;
}

// abre a conexão
$PDO = db_connect();
 
// SQL para contar o total de registros
// A biblioteca PDO possui o método rowCount(), mas ele pode ser impreciso.
// É recomendável usar a função COUNT da SQL
$sql_count = "SELECT COUNT(*) AS total FROM tbl_cnt_usr WHERE id_usr = $idusr AND id_cli = $idcli";
$stmt_count = $PDO->prepare($sql_count);
$stmt_count->execute();
$total = $stmt_count->fetchColumn();
 
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


      <script>
      function alertNoDel() {
          alert("DESISTA!\nVOCÊ SABE QUE CONTEÚDO PUBLICADO NÃO PODE SER DELETADO, NÃO SABE?! ");
      }

      function alertPub() {
          alert("OH, DEUS... ILUMINA ESSA CRIATURA...\nRAPAZZZ... ESSE CONTEÚDO JÁ ESTÁ BUBLICADO. ESCOLHA OUTRO, VÁ?!");
      }     
      </script>


  </head>

  <body>

     <div class="container" style="margin-bottom:200px;">

        <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas -->
        <div class="row">
          <div class="col-md-12" style="text-align:left;margin:50px 0 10px 0;">
              <img src="https://www.holodroide.com/images/logo_holodroide_sistema.png" width="300px" height="34px"><br />
              <h3>CLIENTE - ALTERAR CADASTRO</h3><br>
              <img src="https://holodroide.com/sistema/cliente/arquivos/<? echo $_SESSION['cli_img']; ?>" style="height:40px;"><br>
              USUÁRIO: <a href="#"><?php echo $_SESSION['cli_name']; ?></a>
          </div>
        </div>      

        <!-- Mneu top horizontal -->
        <div class="row">
            <div class="col-md-12" style="text-align:left;margin:20px 0 10px 0;padding:0;">
                <div style="margin:0 auto;text-align:center;border:1px;max-width:800px;display: inline">
                    <div style="display: inline">
                        <a href="index.php" class="btn" style="background-color:#d6b9d8;margin:2px;" role="button">HOME</a>           
                    </div>

                    <div class="dropdown" style="display: inline">

                    <div class="dropdown" style="display: inline">
                        <button class="btn dropdown-toggle" style="background-color:#d6b9d8;margin:2px;" type="button" data-toggle="dropdown">CADASTRO
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a href="cli-edit-form.php?idcli=<?php echo $idcli ?>" class="btn" style="width:200px;margin:5px; background-color:#d6b9d8;" role="button">ALTERAR CADASTRO</a>
                          <li><a href="cli-pw-form.php?idcli=<?php echo $idcli ?>" class="btn" style="width:200px;margin:5px; background-color:#d6b9d8;" role="button">ALTERAR SENHA</a> 
                        </ul>
                    </div>

                    <div class="dropdown" style="display: inline">
                        <button class="btn dropdown-toggle" style="background-color:#d6b9d8;margin:2px;" type="button" data-toggle="dropdown">USUÁRIOS
                        <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                          <li><a href="usr-painel.php" class="btn" style="background-color:#d6b9d8;margin:2px;"  role="button">LISTAR</a></li>
                          <li><a href="usr-add-form.php" class="btn" style="background-color:#d6b9d8;margin:2px;" role="button">INSERIR</a></li>
                        </ul>
                    </div>

                    <div style="display: inline">
                        <a href="#" class="btn" style="background-color:#d6b9d8;margin:2px;">CONTEÚDO</a>  
                    </div>                    

                    <div style="display: inline">
                        <a href="cli-logout.php" class="btn" style="background-color:#d6b9d8;margin:2px;">LOGOUT</a>  
                    </div>
                </div>
            </div>  

        </div>

      <div class="row">
          <div class="col-md-12" style="text-align:left;margin:0 0 30px 0;">
            <strong>REGISTROS:</strong> <?php echo $total ?>
          </div>
      </div>  


      <?php  
      if ($total > 0):

      //$sql1 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_cnt_usr.id_usr = $idusr AND tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'txt'  ORDER BY tbl_cnt_usr.id_cnt DESC";        
$sql1 = "SELECT * FROM tbl_cnt_usr  WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'txt'  ORDER BY id_cnt DESC";              $sql1 = "SELECT * FROM  tbl_cnt_usr WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'txt'  ORDER BY id_cnt DESC";              
      $stmt = $PDO->prepare($sql1);
      $stmt->execute();
      $total1 = $stmt->fetchColumn();
      if ($total1 > 0):
        ?>
       <div class="row" style="border-bottom:1px dashed #000;padding:10px;background-color:#ccc;">
          <div class="col-md-12" style="text-align:center;">
            <h1>TXT</h1>
          </div>          
      </div> 

      <?php
      // Loop para exibir conteúdo tipo TXT
      while ($user1 = $stmt->fetch(PDO::FETCH_ASSOC)):  
      ?>

      <div class="row" style="border-bottom:1px dashed #000;padding:10px;">
          <div class="col-md-2" style="text-align:left;">
            <? echo $user1['data_cnt'] ?>
          </div>  
             
          <div class="col-md-8" style="text-align:left;">

                <?php

                  echo $user1['text_cnt'];

                ?>
                
          </div>
          <div class="col-md-2" style="text-align:left;">
            <?php
              if ($user1['status_cnt'] == 'N') {
                echo '<a href="cli-pub-cnt.php?status=S&idcnt='.$user1['id_cnt'].'&idcli='.$user1['id_cli'].'&tipocnt='.$user1['tipo_cnt'].'" class="btn" style="width:150px;padding:5px;margin:2px;background-color:#ddd;" role="button">PUBLICAR</a>';                
                echo '<br><a href="cli-delete-cnt.php?idcnt='.$user1['id_cnt'].'&idcli='.$user1['id_cli'].'&nomecli='.$nomecli.'" class="btn"  style="width:150px;padding:5px;margin:2px;background-color:#ddd;color:#ff0000;" role="button">DELETAR</a>';                              
              } else {
                echo '<a href="#" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                echo '<br><a href="#" class="btn" style="width:150px;padding:5px;margin:2px;background-color:#ddd;color:#aaa;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
              }
            ?>  
          </div> 
      </div>  

      <?php
       endwhile;
       endif;

      // Query SQL para selecionar os registros tipo IMG
      // $sql2 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_usr.id_cli = $idcli AND tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'img'  ORDER BY tbl_cnt_usr.id_cnt DESC";
      // $sql2 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'img'  ORDER BY tbl_cnt_usr.id_cnt DESC";

 //$sql2 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_cnt_usr.id_usr = $idusr AND tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'img'  ORDER BY tbl_cnt_usr.id_cnt DESC";                
   $sql2 = "SELECT * FROM tbl_cnt_usr WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'img'  ORDER BY id_cnt DESC";              $sql1 = "SELECT * FROM  tbl_cnt_usr WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'txt'  ORDER BY id_cnt DESC";              
      $stmt = $PDO->prepare($sql2);
      $stmt->execute();
      $total2 = $stmt->fetchColumn();
      if (!empty($total2)):  
      ?>
       <div class="row" style="border-bottom:1px dashed #000;padding:10px;background-color:#ccc;">
          <div class="col-md-12" style="text-align:center;">
            <h1>IMG</h1>
          </div>          
      </div> 
      <?php  
      // Loop para exibir conteúdo tipo IMG
      while ($user2 = $stmt->fetch(PDO::FETCH_ASSOC)): 
       ?>
      <div class="row" style="border-bottom:1px dashed #000;padding:10px;">
          <div class="col-md-2" style="text-align:left;">
            <? echo $user2['data_cnt'] ?>
          </div>  
             
          <div class="col-md-8" style="text-align:left;">

                <?php

                  echo '<img src="https://holodroide.com/sistema/uploaders/foto/'.$user2['text_cnt'].'" width="270px">';

                ?>
                
          </div>
          <div class="col-md-2" style="text-align:left;">
            <?php
              if ($user2['status_cnt'] == 'N') {
                echo '<a href="cli-pub-cnt.php?status=S&idcnt='.$user2['id_cnt'].'&idcli='.$user2['id_cli'].'&tipocnt='.$user2['tipo_cnt'].'" class="btn" style="width:150px;padding:5px;margin:2px;background-color:#ddd;" role="button">PUBLICAR</a>';                
                echo '<br><a href="cli-delete-cnt.php?idcnt='.$user2['id_cnt'].'&idcli='.$user2['id_cli'].'&nomecli='.$nomecli.'" class="btn"  style="width:150px;padding:5px;margin:2px;background-color:#ddd;color:#ff0000;" role="button">DELETAR</a>';                              
              } else {
                echo '<a href="#" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                echo '<br><a href="#" class="btn" style="width:150px;padding:5px;margin:2px;background-color:#ddd;color:#aaa;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
              }
            ?>  
          </div> 
      </div>  

      <?php
      endwhile;
      endif;

      // Query SQL para selecionar os registros tipo VID
      // $sql3 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_usr.id_cli = $idcli AND tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'vid'  ORDER BY tbl_cnt_usr.id_cnt DESC";
      // $sql3 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_cnt_usr.id_cli = $idcli AND tbl_cnt_usr.tipo_cnt = 'vid'  ORDER BY tbl_cnt_usr.id_cnt DESC";
      // $sql3 = "SELECT * FROM tbl_usr inner join tbl_cnt_usr on tbl_usr.id_usr = tbl_cnt_usr.id_usr WHERE tbl_cnt_usr.id_cli = $idusr AND tbl_cnt_usr.tipo_cnt = 'vid'  ORDER BY tbl_cnt_usr.id_cnt DESC";              
      $sql3 = "SELECT * FROM tbl_cnt_usr WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'vid'  ORDER BY id_cnt DESC";              $sql1 = "SELECT * FROM  tbl_cnt_usr WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'txt'  ORDER BY id_cnt DESC";              
      $stmt = $PDO->prepare($sql3);
      $stmt->execute();
      $total3 = $stmt->fetchColumn();
      if ($total3 > 0):  
      ?>
       <div class="row" style="border-bottom:1px dashed #000;padding:10px;background-color:#ccc;">
          <div class="col-md-12" style="text-align:center;">
          <h1>VID</h1>
          </div>          
      </div> 
      <?php
      // Loop para exibir conteúdo tipo VID
      while ($user3 = $stmt->fetch(PDO::FETCH_ASSOC)): 
       ?>
      <div class="row" style="border-bottom:1px dashed #000;padding:10px;">
          <div class="col-md-2" style="text-align:left;">
            <? echo $user3['data_cnt'] ?>
          </div>  
            
          <div class="col-md-8" style="text-align:left;">

                <?php
                echo '<video width="270" controls="controls">';
                echo '<source src="'.$user3['text_cnt'].'" type="video/mp4">';
                echo '<object data="" width="270">';
                echo '<embed width="270" src="'.$user3['text_cnt'].'">';
                echo '</object>';
                ?>
                
          </div>
          <div class="col-md-2" style="text-align:left;">
            <?php
              if ($user3['status_cnt'] == 'N') {
                echo '<a href="cli-pub-cnt.php?status=S&idcnt='.$user3['id_cnt'].'&idcli='.$user3['id_cli'].'&tipocnt='.$user3['tipo_cnt'].'" class="btn" style="width:150px;padding:5px;margin:2px;background-color:#ddd;" role="button">PUBLICAR</a>';                
                echo '<br><a href="cli-delete-cnt.php?idcnt='.$user3['id_cnt'].'&idcli='.$user3['id_cli'].'&nomecli='.$nomecli.'" class="btn"  style="width:150px;padding:5px;margin:2px;background-color:#ddd;color:#ff0000;" role="button">DELETAR</a>';                              
              } else {
                echo '<a href="#" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                echo '<br><a href="#" class="btn" style="width:150px;padding:5px;margin:2px;background-color:#ddd;color:#aaa;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
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
