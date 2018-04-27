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
$idusr  = isset($_SESSION['usr_id']) ? $_SESSION['usr_id'] : null;
$datacnt = date('d/m/Y H:i:s');
$tipocnt = isset($_POST['tipo_cnt']) ? $_POST['tipo_cnt'] : null;
$status = 'S'; 
$idcli = $_SESSION['id_cli'];


// Verifica se um arquivo foi enviado
if (isset($_FILES['file']) && !empty($_FILES['file']['name'])){

  $name = ''; $type = ''; $size = ''; $error = ''; 

  function compress_image($source_url, $destination_url, $quality) {
    
      $info = getimagesize($source_url);
  
      if ($info['mime'] == 'image/jpeg')
        $image = imagecreatefromjpeg($source_url);

      // if (!$image){
        // $image= imagecreatefromstring(file_get_contents($source_url));
      // }

      elseif ($info['mime'] == 'image/gif')
        $image = imagecreatefromgif($source_url);

      elseif ($info['mime'] == 'image/png')
        $image = imagecreatefrompng($source_url);

      // Salva o arquivo
      // Faz a compressão. 0 (baixa qualidade, arquivo pequeno) até 100 (melhor qualidade, arquivo grande)
      imagejpeg($image, $destination_url, $quality);
      return $destination_url;

      // Libera memória apagando dados limpando variável
      // imagedestroy($image);

      } 


      // Confere se o arquivo foi enviado 
      if ($_POST) {

      // Confere se existe algum erro no arquivo enviado. 
      // Se existir algum erro, exibe mensagem
      if ($_FILES["file"]["error"] > 0) {
  
        $error = $_FILES["file"]["error"];

        echo '<script>
        alert("Erro: '.$error.'");
        window.history.back()
        </script>';
        exit;

    // Se não existir erro na imagem enviada, confere o formato do arquivo
    } else if (($_FILES["file"]["type"] == "image/gif") ||
              ($_FILES["file"]["type"] == "image/jpeg") ||
  		        ($_FILES["file"]["type"] == "image/jpg") ||
  	        	($_FILES["file"]["type"] == "image/JPG") ||
              ($_FILES["file"]["type"] == "image/png") ||
              ($_FILES["file"]["type"] == "image/pjpeg")) {

        // Atribui o arquivo à variável $arquivo
        $arquivo = $_FILES['file'];

        // Separa nome do arquivo da extensão e atribui o valor da extensão à variável $ext
        $ext = explode('.', $arquivo['name']);
        $ext = end($ext);
     
        // Gera o novo nome único com exensãot
        $novoNome = uniqid() . '.' . $ext;

        // Define o local para armadenar os arquivos
        $url = 'fotos/'. $novoNome;

        // Faz a compressão do arquivo e armazena no local definido
        $filename = compress_image($_FILES["file"]["tmp_name"], $url, 100);

        $PDO = db_connect();

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
                $stmt->bindParam(':idcli', $idcli );                
                $stmt->bindParam(':datetxt', $datacnt);     
                $stmt->bindParam(':usrtxt', $novoNome);
                $stmt->bindParam(':tipo', $tipocnt);
                $stmt->bindParam(':status', $status);   
                $stmt->execute();
         
        
                // SQL para selecionar os registros
                $sql = "SELECT * FROM tbl_usr WHERE id_usr = :idusr";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':idusr', $idusr, PDO::PARAM_INT);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);

                 
                $nameNoSpc   =   retiraAcentos(utf8_decode($user['nome_usr']));
                $NomeImg = $nameNoSpc.'-img-'.$user['redir_usr'];

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

            

                $headerimg  = "<?php".$quebra;
                $headerimg .= "header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );".$quebra;
                $headerimg .= "header( 'Last-Modified: '. gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) .' GMT' );".$quebra;
                $headerimg .= "header( 'Cache-Control: no-store, no-cache, must-revalidate' );".$quebra;
                $headerimg .= "header( 'Cache-Control: post-check=0, pre-check=0', false );".$quebra;
                $headerimg .= "header( 'Pragma: no-cache' );".$quebra;
                $headerimg .= "header( 'Location:https://www.holodroide.com/sistema_bares/uploaders/".$dircnt."/".$novoNome."');".$quebra;
                $headerimg .= "?>";


                $file = fopen('../redirect/'.$NomeImg, 'w');
                fwrite($file, $headerimg);
                fclose($file);


        if ($stmt->execute()){

         /* $to = "heliosouzajr@hotmail.com, gianpierogadotti@gmail.com";
          $subject = "HOLODROIDE - Novo conteúdo enviado!";

          $message = "
          <html>
          <head>
          <title>HTML email</title>
          </head>
          <body>
          <p>Olá (Não esquecer de incluir o nome do cliente aqui!)...</p>
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

          mail($to,$subject,$message,$headers);*/
          

          echo '<script>
          alert("Imagem enviada com sucesso!");
          window.location.assign("http://holodroide.com/sistema/usuario/index.php");
          </script>';
          exit; 

        } else {

          echo '<script>
          alert("Erro ao cadastrar: '.print_r($stmt->errorInfo()).'.");
          window.history.back()
          </script>';
          exit; 



        }

      } 

    } else {

        echo '<script>
        alert("Extensão inválida. Apenas arquivos jpeg, gif ou png são aceitos.");
        window.history.back()
        </script>';
        exit;

    }

} else{

    echo '<script>
    alert("Volte e escolha um arquivo para enviar!");
    window.history.back()
    </script>';
    exit; 

}

?>
