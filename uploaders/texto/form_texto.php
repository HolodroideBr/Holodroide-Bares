<?php
session_start();
 
require_once '../../usuario/include/init.php';
require '../../usuario/include/check.php'; 

header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

// pega os dados do formuário
$idusr  = $_SESSION['usr_id'];
$datacnt = date('d/m/Y H:i:s');
$usrtxt = isset($_POST['addition']) ? $_POST['addition'] : null;
$tipocnt = isset($_POST['tipo_cnt']) ? $_POST['tipo_cnt'] : null;
$status = 'N';

// Pega o nome do arquivo do logo do cliente no BD
$idcli = $_SESSION['id_cli'];

// abre a conexão
$PDO = db_connect();
 
// SQL para selecionar os registros
$sql = "SELECT imglogo_cli, nome_cli FROM tbl_cli WHERE id_cli = $idcli";
 
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC)


?>

<!doctype html>
<html>
  <head>

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
    <link href="../../css/holodroide.css?<?php echo date('l jS \of F Y h:i:s A'); ?>" rel="stylesheet">
    
    <!-- Custom fonts -->
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,800' rel='stylesheet' type='text/css'>
    <link href="../../css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/ionicons.min.css" rel="stylesheet" type="text/css">
    <link href="../../css/animate.min.css" rel="stylesheet" type="text/css">

    <title>Texto Uploader</title>

    <style type="text/css">

    body {
    	background-color: #fff;
    	margin-left: 0px;
    	margin-top: 0px;
    	margin-right: 0px;
    	margin-bottom: 0px;
    }

    </style>

    <script type="text/javascript">

      function limitTextareaLine(e) {
          if(e.keyCode == 5 && $(this).val().split("\n").length >= $(this).attr('rows')) { 
              return false;
          }
      }

    </script>

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
                    <img src="http://holodroide.com/sistema/cliente/arquivos/<? echo $user['imglogo_cli'] ?>" style="width:100%;"> 
                </div>                   
            </div>
          </div>

          <div class="row">
            <div class="col-md-12" style="text-align:center;margin:0 0 30px 0;">
              <strong>ENVIO DE TEXTO</strong>                
            </div>
          </div>            

          <div class="row">
              <div class="col-md-12" style="text-align:center;;margin:0 0 30px 0;">
                  <p><h6><?php echo $_SESSION['usr_name']; ?><br><br>
Escreva um novo texto no box abaixo.</h6></p>
              </div>
          </div>



          <div class="row">
            <div class="col-md-12" style="text-align:center;margin:0 0 10px 0;">

              <form action="uploader_texto.php" method="POST">
                <textarea style="overflow:hidden" name="addition" cols='35' rows='5' maxlength="105" onkeydown="return limitLines(this, event)"></textarea>
                <br>
                <input type="hidden" name="tipo_cnt" id="tipo_cnt" value="txt">
                <input type="submit" name="button" class="btn btn-primary" value='ENVIAR' style="width:100%;max-width:270px;">
              </form>


              <script type="text/javascript">
                    var keynum, lines = 1;

                    function limitLines(obj, e) {
                      // IE
                      if(window.event) {
                        keynum = e.keyCode;
                      // Netscape/Firefox/Opera
                      } else if(e.which) {
                        keynum = e.which;
                      }

                      if(keynum == 13) {
                        if(lines == obj.rows) {
                          return false;
                        }else{
                          lines++;
                        }
                      }
                    }
              </script>
  
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