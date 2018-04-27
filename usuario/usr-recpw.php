<?php
session_start();
 
require_once 'include/init.php';


header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );

// pega os dados do formuário
$email = isset($_POST['email']) ? $_POST['email'] : null;
//$idcli = $_SESSION['id_cli'];


 if (empty($email)){
    $_SESSION['acao'] = 'vazio';
    header('Location: usr-recpw-form.php');
    exit;
}


// abre a conexão
$PDO = db_connect();
// Executa query para buscar os dados do usuário do administrador
$sql = "SELECT id_usr, nome_usr, email_usr FROM tbl_usr WHERE email_usr = :email";
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':email', $email);   
$stmt->execute();  
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$emailusr = $user['email_usr'];


 if (!empty($emailusr)){

      $to = $emailusr;
      //$to = "gian@diglink.com.br";
      $subject = "HOLODROIDE - Recuperar senha";

      $message = "
      <html>
      <head>
      <title>HTML email</title>
      </head>
      <body>
      <p>Olá ".$user['nome_usr']."</p>
      <table>
      <tr>
      <td>Você recebeu esse email pois solicitou para recuperar a senha de acesso.<br> <br>
      Clique no link abaixo para completar o procedimento.<br><br>
      <a href='http://holodroide.com/sistema/usuario/usr-recpw-new-form.php?idusr=".$user['id_usr']." target='_new'>Recuperar senha!</a><br><br></td>
      </tr>
      <tr>
      <td>Se precisar de ajuda, fale conosco <a href='mailto:suporte@holodroide.com.br' target='_new'>suporte@holodroide.com.br</a></td>
      </tr>
      </table>
      </body>
      </html>
      ";

      // Always set content-type when sending HTML email
      $headers = "MIME-Version: 1.0" . "\r\n";
      $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

      // More headers
      $headers .= 'From: <supoerte@holodroide.com.br>' . "\r\n";

      mail($to,$subject,$message,$headers);

     // echo '<script>
      //alert("Confira seu email e siga as intruções para recuperar sua senha!");
      //window.history.back();
      //</script>';
      //exit;
    $_SESSION['acao'] = 'ok';
    header('Location: usr-recpw-form.php');
    exit;
      }else{

    $_SESSION['acao'] = 'noreg';
    header('Location: usr-recpw-form.php');
        exit;

        }

?>
