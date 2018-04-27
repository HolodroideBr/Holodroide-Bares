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

$sql2 = "SELECT * FROM tbl_cli  WHERE id_cli = $idcli"; 
$stmt = $PDO->prepare($sql2);
$stmt->execute();
$user2 = $stmt->fetch(PDO::FETCH_ASSOC);
 
?>

<!DOCTYPE html>
<html lang="en">



  <head>

      <title>HOLODROIDE ADMIN</title>        

      <!-- Meta tags iniciais -->
    
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

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


      <script>
      function alertNoDel() {
          alert("NÃO PERMITIDO\nCONTEÚDO PUBLICADO NÃO PODE SER DELETADO.");
      }

      function alertPub() {
          alert("ESSE CONTEÚDO JÁ ESTÁ BUBLICADO. ESCOLHA OUTRO POR FAVOR.");
      }     
      </script>


  </head>

  <body>

     <div class="container" style="margin-bottom:200px;">

        <!-- Cabeçalho (logotipo, menu top horizontal e mensagem de boas vindas -->
        <div class="row">
          <div class="col-md-12" style="text-align:left;margin:50px 0 10px 0;">
              <img src="../../images/logo_holodroide_sistema.png" width="300" height="32" alt=""/><br />
              <h4>CLIENTE - CONTEÚDOS</h4><br>
              <img src="https://holodroide.com/sistema/cliente/arquivos/<? echo $_SESSION['cli_img']; ?>" style="height:40px;"><br>
              EMPRESA: <a href="#"><?php echo strtoupper($user2['empresa_cli']) ?></a>
          </div>
        </div>  
        
        
            

        <!-- Menu topo horizontal Início -->
        
        <div class="row">
            <div class="col-md-12" style="text-align:left;margin:20px 0 10px 0;padding:0;">
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
        
        <!-- Menu topo horizontal Fim -->
        
        

      <div class="row">
          <div class="col-md-12" style="text-align:left;margin:0 0 30px 0;">
            <h5><strong>USUÁRIO:</strong> <?php echo $nomeusr ?><br>
            <strong>REGISTROS:</strong> <?php echo $total ?></h5>
          </div>
      </div>  


      <?php  

      if ($total > 0){

        if($user2['tipo_txt']){ 

          $sql1 = "SELECT * FROM tbl_cnt_usr  WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'txt'  ORDER BY id_cnt DESC"; 
          $stmt = $PDO->prepare($sql1);
          $stmt->execute();

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

            <div class="row" style="border-bottom:0px;padding:10px;">

                <div class="col-md-2" style="text-align:left;">

                  <?php
                    if ($user1['status_cnt'] == 'N') {
                      echo '<a href="usr-pub-cnt.php?status=S&idcnt='.$user1['id_cnt'].'&idusr='.$user1['id_usr'].'&tipocnt='.$user1['tipo_cnt'].'&textcnt='.$user1['text_cnt'].'" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button">PUBLICAR</a>';                
                      echo '<br><a href="usr-delete-cnt.php?idcnt='.$user1['id_cnt'].'&idusr='.$user1['id_usr'].'&nomecli='.$nomecli.'" class="btn btn-danger"  style="width:150px;padding:5px;margin:2px;" role="button">DELETAR</a>';                              
                    } else {
                      echo '<a href="#" class="btn btn-primary" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                      echo '<br><a href="#" class="btn btn-danger" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
                    }
                  ?>  
                  
                </div> 

                <div class="col-md-2" style="text-align:left;">

                  <h5><? echo $user1['data_cnt'] ?></h5>

                </div>  
                   
                <div class="col-md-8" style="text-align:left;">

                  <h5><?php echo $user1['text_cnt']; ?></h5>
                      
                </div>

            </div>  
       
        <?php

          endwhile;
        }
        if($user2['tipo_img']){ 

          $sql1 = "SELECT * FROM tbl_cnt_usr  WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'img'  ORDER BY id_cnt DESC"; 
          $stmt = $PDO->prepare($sql1);
          $stmt->execute();
        
        ?>
       
          <div class="row" style="border-bottom:0px;margin-bottom:10px;background-color:#ccc;">
              <div class="col-md-12" style="text-align:center;">
                <h3><strong>FOTOS</strong></h3>
              </div>          
          </div> 

          <?php
          // Loop para exibir conteúdo tipo TXT
          while ($user1 = $stmt->fetch(PDO::FETCH_ASSOC)):  
          ?>

          <div class="row" style="border-bottom:0px;padding:10px;">

                <div class="col-md-2" style="text-align:left;">

                  <?php
                    if ($user1['status_cnt'] == 'N') {
                      echo '<a href="usr-pub-cnt.php?status=S&idcnt='.$user1['id_cnt'].'&idusr='.$user1['id_usr'].'&tipocnt='.$user1['tipo_cnt'].'&textcnt='.$user1['text_cnt'].'" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button">PUBLICAR</a>';                
                      echo '<br><a href="usr-delete-cnt.php?idcnt='.$user1['id_cnt'].'&idusr='.$user1['id_usr'].'&nomecli='.$nomecli.'" class="btn btn-danger"  style="width:150px;padding:5px;margin:2px;" role="button">DELETAR</a>';                              
                    } else {
                      echo '<a href="#" class="btn btn-primary" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                      echo '<br><a href="#" class="btn btn-danger" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
                    }
                  ?>  
                  
                </div> 

              <div class="col-md-2" style="text-align:left;">
                <h5><? echo $user1['data_cnt'] ?></h5>
              </div>  
                 
              <div class="col-md-8" style="text-align:left;">

                <?php

                  echo '<img src="http://holodroide.com/sistema/uploaders/foto/fotos/'.$user1['text_cnt'].'" width="270px">';

                ?>
                    
              </div>

          </div>  

        <?php
          endwhile;
        }
        if($user2['tipo_vid']){ 

          $sql1 = "SELECT * FROM tbl_cnt_usr  WHERE id_usr = $idusr AND id_cli = $idcli AND tipo_cnt = 'vid'  ORDER BY id_cnt DESC"; 
          $stmt = $PDO->prepare($sql1);
          $stmt->execute();
          
        ?>

          <div class="row" style="border-bottom:0px;margin-bottom:10px;background-color:#ccc;">
              <div class="col-md-12" style="text-align:center;">
                <h3><strong>VÍDEOS</strong></h3>
              </div>          
          </div> 

          <?php
          // Loop para exibir conteúdo tipo TXT
          while ($user1 = $stmt->fetch(PDO::FETCH_ASSOC)):  
          ?>

          <div class="row" style="border-bottom:0px;padding:10px;">

                <div class="col-md-2" style="text-align:left;">

                  <?php
                    if ($user1['status_cnt'] == 'N') {
                      echo '<a href="usr-pub-cnt.php?status=S&idcnt='.$user1['id_cnt'].'&idusr='.$user1['id_usr'].'&tipocnt='.$user1['tipo_cnt'].'&textcnt='.$user1['text_cnt'].'" class="btn btn-success" style="width:150px;padding:5px;margin:2px;" role="button">PUBLICAR</a>';                
                      echo '<br><a href="usr-delete-cnt.php?idcnt='.$user1['id_cnt'].'&idusr='.$user1['id_usr'].'&nomecli='.$nomecli.'" class="btn btn-danger"  style="width:150px;padding:5px;margin:2px;b" role="button">DELETAR</a>';                              
                    } else {
                      echo '<a href="#" class="btn btn-primary" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertPub()">PUBLICADO</a>';
                      echo '<br><a href="#" class="btn btn-danger" style="width:150px;padding:5px;margin:2px;" role="button" onclick="alertNoDel()">DELETAR</a>';                              
                    }
                  ?>  
                  
                </div> 

              <div class="col-md-2" style="text-align:left;">
                <h5><? echo $user1['data_cnt'] ?></h5>
              </div>  
                 
              <div class="col-md-8" style="text-align:left;">

                <?php
                echo '<video width="270" controls="controls">';
                echo '<source src="https://holodroide.com/sistema/uploaders/video/converted_videos/'.$user1['text_cnt'].'" type="video/mp4">';
                echo '<object data="" width="270">';
                echo '<embed width="270" src="https://holodroide.com/sistema/uploaders/video/converted_videos/'.$user1['text_cnt'].'">';
                echo '</object>';
                ?>
                    
              </div>

          </div>  

        <?php
          endwhile;
        }
        }else{
        ?>
 
          <div class="row" style="border-bottom:0px;padding:10px;background-color:#ccc;">
              <div class="col-md-12" style="text-align:center;">
              <h4><strong>NENHUM CONTEÚDO REGISTRADO</strong></h4>
              </div>          
          </div>

          <div class="row" style="padding:10px;">
              <div class="col-md-12" style="text-align:center;">
                <input type="button" name="button" id="button" class="btn btn-info" value="VOLTAR" onclick="window.history.back()" />                               
              </div>          
          </div>            
 
      <?php } ?>

</div>
    </div>

  </body>
</html>
