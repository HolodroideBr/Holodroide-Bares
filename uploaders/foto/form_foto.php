<?php
session_start();
 
require_once '../../usuario/include/init.php';
require '../../usuario/include/check.php'; 

header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );


// Pega o nome do arquivo do logo do cliente no BD
$idcli = $_SESSION['id_cli'];

// abre a conexão
$PDO = db_connect();
 
// SQL para selecionar os registros
$sql = "SELECT imglogo_cli FROM tbl_cli WHERE id_cli = $idcli";
 
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC)

?>

<html>
    <head>
      <title></title>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  
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
    <link href="../../css/holodroide.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">
    
    <!-- Custom fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/animate.min.css" rel="stylesheet" type="text/css">

      <style type="text/css">
        body {
        	background-color: #fff;
        	margin-left: 0px;
        	margin-top: 0px;
        	margin-right: 0px;
        	margin-bottom: 0px;
        }
      </style>


      <!-- NO mouse right button (part 1) -->
      <script language="JavaScript" type="text/JavaScript">
        <!--
        function disableselect(e){
        return false
        } 

        function reEnable(){
        return true
        } 

        //if IE4+
        document.onselectstart=new Function ("return false") 

        //if NS6
        if (window.sidebar){
        document.onmousedown=disableselect
        document.onclick=reEnable
        }
        //-->
      </script>



  </head>
  <body>

    <!-- NO mouse right button (part 2) -->
    <script language=JavaScript>
    var message="";
    ///////////////////////////////////
    function clickIE() {if (document.all) {(message);return false;}}
    function clickNS(e) {if 
    (document.layers||(document.getElementById&&!document.all)) {
    if (e.which==2||e.which==3) {(message);return false;}}}
    if (document.layers) 
    {document.captureEvents(Event.MOUSEDOWN);document.onmousedown=clickNS;}
    else{document.onmouseup=clickNS;document.oncontextmenu=clickIE;}
    document.oncontextmenu=new Function("return false")
    // --> 
    </script>

      <div class="container">
     

        <div class="row">
          <div class="col-md-12" style="text-align:center;margin:0px 0 20px 0;">
              <div style="max-width:120px;margin:0 auto;">
                  <img src="https://holodroide.com/sistema/cliente/arquivos/<?php echo $user['imglogo_cli'] ?>" style="width:100%;"> 
              </div>                   
          </div>
        </div>

        <div class="row">
          <div class="col-md-12" style="text-align:center;margin:0 0 30px 0;">
            <strong>ENVIO DE FOTO</strong>
          </div>
        </div> 

        <div class="row">
            <div class="col-md-12" style="text-align:center;;margin:0 0 30px 0;">
                <p><h6><?php echo $_SESSION['usr_name']; ?><br><br>
Faça uma selfie ou escolha <br>uma foto e clique ENVIAR.</h6></p>
            </div>
        </div>

        <div class="row">
          <div class="col-md-12" style="text-align:center;margin:0 0 10px 0;">

            <div align="center">

              <form action="uploader_foto.php" name="img_compress" id="img_compress" method="post" enctype="multipart/form-data">
                <input type="file" name="file" id="file"/ accept="image/*" capture="camera" style="width:100%;max-width:270px;"/>
                <br><br>
                <input type="hidden" name="tipo_cnt" id="tipo_cnt" value="img">
                <input type="submit" name="submit" id="submit" value='ENVIAR' class="btn btn-primary" style="width:100%;max-width:270px;"/>
              </form>

            </div>

          </div>
        </div> 

        <div class="row">
            <div class="col-md-12" style="text-align:center;margin:30px 0 0 0;">            
                <a href="../../usuario/index.php" class="btn btn-danger" style="width:100%;max-width:270px;font-size:0.800em;">HOME</a>
            </div>                
        </div>          

        <div class="row">
            <div class="col-md-12" style="text-align:center;margin:10px 0 0 0;">            
                <a href="../../usuario/usr-logout.php" class="btn btn-danger" style="width:100%;max-width:270px;font-size:0.800em;">LOGOUT</a>
            </div>                
        </div>


        <div class="row">
            <div class="col-md-12" style="text-align:center;margin:50px 0 50px 0;">
                <div style="max-width:250px;margin:0 auto;">
                    <img src="https://www.holodroide.com/images/logo_holodroide_sistema.png?1222259157.415" width="200px" height="23px"><br /><br />

                </div>
                <h6>© 2018 | Todos os direitos reservados</h6>
            </div>
        </div>     

    </div> 



  </body>
</html>