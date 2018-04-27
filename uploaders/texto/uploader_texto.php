<?php
session_cache_expire(525600);
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
$status = 'S';
$idcli = $_SESSION['id_cli'];

// abre a conexão
$PDO = db_connect();
 
// validação (bem simples, mais uma vez)
if(empty($usrtxt)) {
      echo "<script>
          alert('VOLTE E DIGITE ALGUM TEXTO!');
          window.history.back()
      </script>";
    exit;
}


  // Atualiza todos os registros do cliente no BD para status N
  $sql = "UPDATE tbl_cnt_usr SET status_cnt = 'N' WHERE id_usr = :idusr AND id_cli = :idcli AND tipo_cnt = :tipocnt";
  $stmt = $PDO->prepare($sql);
  $stmt->bindParam(':tipocnt', $tipocnt);     
  $stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
  $stmt->bindParam(':idusr', $idusr, PDO::PARAM_INT); 
  $stmt->execute(); 


  //Insere todas as informações no BD
  $sql = "INSERT INTO tbl_cnt_usr(id_usr, id_cli, data_cnt, text_cnt, tipo_cnt, status_cnt ) VALUES(:idusr, :idcli, :datetxt, :usrtxt, :tipo, :status )";
  $stmt = $PDO->prepare($sql);
  $stmt->bindParam(':idusr', $idusr);
  $stmt->bindParam(':idcli', $idcli);                
  $stmt->bindParam(':datetxt', $datacnt);     
  $stmt->bindParam(':usrtxt', $usrtxt);
  $stmt->bindParam(':tipo', $tipocnt);
  $stmt->bindParam(':status', $status); 
  $stmt->execute();  

  // SQL para selecionar os registros
  $sql = "SELECT nome_usr, redir_usr FROM tbl_usr WHERE id_usr = $idusr";
  $stmt = $PDO->prepare($sql);
  $stmt->execute();  
  $user = $stmt->fetch(PDO::FETCH_ASSOC);

  $nameNoSpc   =   retiraAcentos(utf8_decode($user['nome_usr']));
  $NomeTxt = $nameNoSpc.'-txt-'.$user['redir_usr'];

  $quebra = chr(13).chr(10);//essa é a quebra de linha


    $dircnt = '';
    if ($tipocnt == 'txt') {
      $dircnt = 'texto/textos';
    } 
    if ($tipocnt == 'img') {
      $dircnt = 'foto/fotos';
    } 
    if ($tipocnt == 'vid') {
      $dircnt = 'video/converted_videos';
    }


    $headertxt  = "<?php".$quebra;
    $headertxt .= "header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );".$quebra;
    $headertxt .= "header( 'Last-Modified: '. gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) .' GMT' );".$quebra;
    $headertxt .= "header( 'Cache-Control: no-store, no-cache, must-revalidate' );".$quebra;
    $headertxt .= "header( 'Cache-Control: post-check=0, pre-check=0', false );".$quebra;
    $headertxt .= "header( 'Pragma: no-cache' );".$quebra;
    $headertxt .= "?>".$quebra;
    $headertxt .=  $usrtxt;



    $file = fopen('../redirect/'.$NomeTxt, 'w');
    fwrite($file, $headertxt);
    fclose($file);


    if ($stmt->execute()){

      /*$to = "heliosouzajr@hotmail.com, gianpierogadotti@gmail.com";
      $subject = "HOLODROIDE - Novo conteúdo enviado!";

      $message = "
      <html>
      <head>
      <title>HTML email</title>
      </head>
      <body>
      <p>Olá ".$user['nome_cli']."</p>
      <table>
      <tr>
      <th>Você tem novo conteúdo aguardando aprovação.<br> <br>
      Visite <a href='http://holodroide.com/sistema/' target='_new'>HOLODROIDE</a> para ver os novos conteúdos.</th>
      </tr>
      <tr>
      <td>Saiba mais: <a href='www.holodroide.com.br' target='_new'>www.holodroide.com.br</a></td>
      </tr>
      </table>
      </body>
      </html>
      ";

      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: <contato@holodroide.com.br>' . "\r\n";


      echo '<script>
      alert("Texto enviada com sucesso!");
      window.location.assign("../../index.php");
      </script>';
      exit;
      mail($to,$subject,$message,$headers);    */  

      header('Location: ../../usuario/');

      }else{

        echo "<script>
              alert('ERRO: ".print_r($stmt->errorInfo())."');
              window.history.back()
              </script>";
        exit;

        }
   // }
?>
