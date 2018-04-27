<?php

if (!isset($_SESSION)) {
    //session_cache_expire(525600);
  session_start();

}

header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );
header( 'Last-Modified: ' . gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) . ' GMT' );
header( 'Cache-Control: no-store, no-cache, must-revalidate' );
header( 'Cache-Control: post-check=0, pre-check=0', false );
header( 'Pragma: no-cache' );



// You can do some initialization for the template here
@date_default_timezone_set(date_default_timezone_get());


require_once '../../usuario/include/init.php';
require '../../usuario/include/check.php'; 


  // pega os dados do formuário
$idusr  = isset($_SESSION['usr_id']) ? $_SESSION['usr_id'] : null;
$datacnt = date('d/m/Y H:i:s');
$tipocnt = 'vid';
$status = 'S'; 
$idcli = $_SESSION['id_cli'];

// abre a conexão
$PDO = db_connect();
 
// SQL para selecionar os registros
$sql = "SELECT imglogo_cli, nome_cli, redir_cli FROM tbl_cli WHERE id_cli = $idcli";
 
// seleciona os registros
$stmt = $PDO->prepare($sql);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC)




?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

    <head>

        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link title="voottavar Style" href="templates/styles/rl_style_pm.css" rel="stylesheet" type="text/css" />

        <title>Uploader Video</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <!-------- jQuery-File-Upload begin -------->
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- Bootstrap styles -->
        <link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">

        <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
        <link rel="stylesheet" href="css/jquery.fileupload.css">


        <link href="templates/styles/rl_style_pm.css" rel="stylesheet" type="text/css" />
        <!-- Generic page styles -->
        <link rel="stylesheet" href="css/style.css">    
        <!-------- jQuery-File-Upload ends -------->
        <script src="js/converter.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    </head>

    <body>
        <!-- Start Site Wrapper -->
        <div id="wrapper">

              <div class="container">
             

                <div class="row">
                  <div class="col-md-12" style="text-align:center;margin:0px 0 20px 0;">
                      <div style="max-width:120px;margin:0 auto;">
                          <img src="http://holodroide.com/sistema/cliente/arquivos/<?php echo $user['imglogo_cli'] ?>" style="width:100%;"> 
                      </div>                   
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12" style="text-align:center;margin:0 0 30px 0;">
                    <strong>ENVIAR VÍDEO</strong>
                  </div>
                </div> 

                <div class="row">
                    <div class="col-md-12" style="text-align:center;;margin:0 0 30px 0;">
                        <p><h6><?php echo $_SESSION['usr_name']; ?><br><br>Selecione o seu vídeo e clique em ENVIAR.</h6></p>
                    </div>
                </div>

            <!-- /div -->
      

            <!-- Start Content Wrapper -->
            <div id="contentWrapper">

            <!-- Start Body Area -->

            <?php

            require_once("languages/en.php");
            include ("includes/settings.php");
            include("includes/functions.php");
            include("includes/LIB_parse.php");
            include("classes/other.php");

            cron(); // to run cron job to delete all files

            if(isset($_POST['uploader_0_name']) or isset ($_GET['uploaded_name'])) {

            	if(isset($_POST['uploader_0_name'])) {

                    list($_SESSION['original_name'], $ext) = explode('.',$_POST['uploader_0_name']);

                }else{

                    $fullname=$_GET['uploaded_name'];
                }

                if(isset($_POST['uploader_0_name'])) {

                    list($_SESSION['original_name'], $ext) = explode('.',$_POST['uploader_0_name']);

                }else{

                    list($_SESSION['original_name'], $ext) = explode('.',$_GET['uploaded_name']);
                    $_SESSION['original_name']= return_between($_GET['uploaded_name'], '_', "$ext", 'EXCL') ;
                    $_SESSION['original_name']= str_replace(".","",$_SESSION['original_name']); 

                }

                if(isset($_POST['uploader_0_name'])) {	

                    $fullname=	$_POST['uploader_0_tmpname'];

                }else{

                    $fullname=$_GET['uploaded_name'];
                    
                }

                    $ext= pathinfo($fullname, PATHINFO_EXTENSION); 
                    $_SESSION['name']=RemoveExtension($fullname);
                    //$store_dir="php/uploaded/";
                    $_SESSION['converted_vids']=$converted_vids;
                    $_SESSION['temp_dir']=$store_dir;
                    // if those directotires don't exist - create them and give them read/write permissions
                
            if(!is_dir($store_dir)) mkdir($store_dir, 0777); 
            
            if(!is_dir($converted_vids)) mkdir($converted_vids, 0777);
            
            $extension = substr($fullname, strrpos($fullname, "."));
            $video_to_convert=$store_dir.$_SESSION['name'];
            $_SESSION['video_to_convert']=$video_to_convert;
            $_SESSION['extension']=$extension;


            /**************************************************
            check extenxions 
            ***************************************************/	

    	    if (!in_array($ext, $allowedExtensions)) {

                echo '<div  style="text-align:center"><strong>'.$ext."</strong><br> is an invalid file type!<br>Supported files are:<br><strong>";
                
                foreach ($allowedExtensions as $value) { 

                    echo $value . "<br>";
                }
                
                echo "</strong><br>";
                echo "<a href=\"index.php\">"."<img src=\"images/red-back.png\" border=\"0\" /></a></div>";
                
                include("templates/footer.php");
                exit;

            }
            				  
    		$new_format= 'mp4'; // read output format from form
    		$name = $_SESSION['name'];
    		//$_SESSION['extension'];
    		$video_to_convert=$store_dir.$_SESSION['name'].$_SESSION['extension'];
        		
    		$size='512x288';
    		$quality=800000;
    		$audio=11025;
        				
    		// for webm  and ogg audio can not be 11050
            if($new_format=="webm" && $audio=="11025"){
                $audio="22050";$new_format="webm";
            }

    		// for webm  and ogg audio can not be 11050
            if($new_format=="ogg" && $audio=="11025"){
                $audio="22050"; $new_format="ogg";
            }
        		
    		$_SESSION['type']=$new_format;
        		        		
        	if($new_format=="flv"){
                $call=$ffmpeg." -i ".$video_to_convert." -vcodec flv -f flv -r 30 -b ".$quality." -ab 128000 -ar ".$audio." -s ".$size." ".$converted_vids.$name.".".$new_format." -y 2> log/".$name.".txt";
            }
        	        	
        	if($new_format=="avi"){
                $call=$ffmpeg." -i ".$video_to_convert." -vcodec mjpeg -f avi -acodec libmp3lame -b ".$quality." -s ".$size." -r 30 -g 12 -qmin 3 -qmax 13 -ab 224 -ar ".$audio." -ac 2 ".$converted_vids.$name.".".$new_format." -y 2> log/".$name.".txt";
            }
        	
        	if($new_format=="mp3"){
                $call=$ffmpeg." -i ".$video_to_convert." -vn -acodec libmp3lame -ac 2 -ab 128000 -ar ".$audio."  ".$converted_vids.$name.".".$new_format." -y 2> log/".$name.".txt";
            }
        	
        	/* Parâmetros MP4 H264 - Início */
        	
        	if($new_format=="mp4"){
                $call=$ffmpeg." -i ".$video_to_convert."  -vcodec mpeg4 -r 20 -b ".$quality." -c:v libx264 -preset slow -crf 25 -c:a copy -ab 126000 -ar ".$audio." -ac 2 -s ".$size." ".$converted_vids.$name.".".$new_format." -y 2> log/".$name.".txt";
            }
        	
        	/* Parâmetros MP4 H264 - Fim */
        	if($new_format=="wmv"){
                $call=$ffmpeg." -i ".$video_to_convert." -vcodec wmv1 -r 30 -b ".$quality." -acodec wmav2 -ab 128000 -ar ".$audio." -ac 2 -s ".$size." ".$converted_vids.$name.".".$new_format." -y 2> log/".$name.".txt";
            }
        	
        	if($new_format=="ogg"){
                $call=$ffmpeg." -i ".$video_to_convert." -vcodec libtheora -r 30 -b ".$quality." -acodec libvorbis -ab 128000   -ar ".$audio." -ac 2 -s ".$size." ".$converted_vids.$name.".".$new_format." -y 2> log/".$name.".txt";
            }
        	
        	if($new_format=="webm"){
                $call=$ffmpeg." -i ".$video_to_convert." -vcodec libvpx  -r 30 -b ".$quality." -acodec libvorbis -ab 128000   -ar ".$audio." -ac 2 -s ".$size." ".$converted_vids.$name.".".$new_format." -y 2> log/".$name.".txt";
            }
        	
            /* START CONVERTING The Video */
        	require_once("includes/ffmpeg_cmd.php"); 
        	$convert = (popen($convert_call, "r"));
        	pclose($convert);
        	flush();	

            // define sessions
        	$_SESSION['dest_file']=$converted_vids.$name.".".$new_format;

        	echo "<script>\n";
        	echo "counter = 5\n";
        	echo "var redirect = 0; \n";
        	echo "$(document).ready(function()\n";
            echo "{\n";
        	echo "var refreshId = setInterval(function() \n";
        	echo "{\n";
           	echo "if(redirect == 0) \n { \n";
        	echo "$('#timeval').load('progress_bar.php');\n";
        	echo "}\n";
        	echo "else \n";
        	echo "{\n";
        	echo "$('#timeval').load('progress_bar.php?counter='+ counter--);\n";
        	echo "}\n";
        	echo "}, 1000);\n";
            echo "});\n";	
        	echo "</script>\n";
        	
           	//*************************  for debug        *************************************
        	//echo "<pre>";
        	//print_r ($_SESSION);
        	//echo "<pre>";
        	//**********************************************************************************/
          
            ?>

            <!-- div to display results from progress_bar.php  -->
            <center>

                <div id="timeval">
                    <img src="images/wait.gif" alt="wait please"  /><br />
                </div>

            </center>

        	<?php	
        	} else if(isset($_GET['finished'])) {
                            
        		echo '<center class="panel panel-default">';
                echo '<div class="panel-heading">';
                echo '</div><br>';

        		if(!isset($_SESSION['name'])) {

                    echo "<a href=\"index.php\">please convert new video</a>";
                    include("templates/footer.php");;exit;
                }
        		

                // remove punctation from the file name
                $vid_name = $_SESSION['name'].".".$_SESSION['type'];
                $filepath = $converted_vids.$vid_name;
        		
                //require_once"video_duration.php";
        		       					
        		//$_SESSION['duration']=$hours.":".$minutes.":".$seconds;
                $vid_name=$_SESSION['name'];
                $vid_src=$_SESSION['extension'];
                $vid_new=$_SESSION['type'];
                
                if (isset($_SESSION['duration'])) {
                
                    $duration=$_SESSION['duration'];
                
                }else {
                
                    $duration="unknown";
                
                }
                
                if(file_exists($converted_vids.$vid_name.".".$vid_new)){

                    $vid_size=get_size($converted_vids.$vid_name.".".$vid_new);
                    
                }else {
                
                    $vid_size=0;    
                
                }


                // Atualiza todos os registros do cliente no BD para status N
                $sql = "UPDATE tbl_cnt_usr SET status_cnt = 'N' WHERE id_usr = :idusr AND id_cli = :idcli AND tipo_cnt = :tipocnt";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':tipocnt', $tipocnt);         
                $stmt->bindParam(':idcli', $idcli, PDO::PARAM_INT);
                $stmt->bindParam(':idusr', $idusr, PDO::PARAM_INT); 
                $stmt->execute();       


                //Insere todas as informações no BD

                $url = $_SESSION['name'].'.mp4';

                $stmt = $PDO->prepare($sql);       
                $sql = "INSERT INTO tbl_cnt_usr(id_usr, id_cli, data_cnt, text_cnt, tipo_cnt, status_cnt ) VALUES(:idusr, :idcli, :datetxt, :usrtxt, :tipo, :status )";
                $stmt = $PDO->prepare($sql);
                $stmt->bindParam(':idusr', $idusr);
                $stmt->bindParam(':idcli', $idcli );                
                $stmt->bindParam(':datetxt', $datacnt);     
                $stmt->bindParam(':usrtxt', $url);
                $stmt->bindParam(':tipo', $tipocnt);
                $stmt->bindParam(':status', $status);    
                $stmt->execute();


                // Seleciona os campos para escrever os arquivos php de redirect
                $sql = "SELECT nome_usr, redir_usr FROM tbl_usr WHERE id_usr = $idusr";
                $stmt = $PDO->prepare($sql);
                $stmt->execute();
                $user = $stmt->fetch(PDO::FETCH_ASSOC);



                $nameNoSpc   =   retiraAcentos(utf8_decode($user['nome_usr']));
                $NomeImg = $nameNoSpc.'-vid-'.$user['redir_usr'];

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
                        

                $headervid  = "<?php".$quebra;
                $headervid .= "header( 'Expires: Sat, 26 Jul 1997 05:00:00 GMT' );".$quebra;
                $headervid .= "header( 'Last-Modified: '. gmdate( 'D, d M Y H:i:s',time()+60*60*8 ) . ' GMT' );".$quebra;
                $headervid .= "header( 'Cache-Control: no-store, no-cache, must-revalidate' );".$quebra;
                $headervid .= "header( 'Cache-Control: post-check=0, pre-check=0', false );".$quebra;
                $headervid .= "header( 'Pragma: no-cache' );".$quebra;
                $headervid .= "header( 'Location:https://www.holodroide.com/sistema_bares/uploaders/".$dircnt."/".$url."' );".$quebra;
                $headervid .= "?>";



                $file = fopen('../redirect/'.$NomeImg, 'w');
                fwrite($file, $headervid);
                fclose($file);


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

                mail($to,$subject,$message,$headers);*/

                
                echo '<script>window.location.assign("http://holodroide.com/sistema/usuario/index.php");</script>';
                exit; 
            
            	?>
                            
                <!--div class="video_infor">Informações sobre seu vídeo</div>
            	
                <table border="1" class="info_table">
                	<tr>
                		<td>Duração do vídeo</td>
                		<td><?php //echo $hours.":".$minutes.":".$seconds;?></td>
                	</tr>
                	<tr>
                		<td>Nome original do vídeo</td>
                		<td>
                            <?php
                           // if(isset($_SESSION['original_name'])){
                            //    echo $_SESSION['original_name'];
                            //    echo $_SESSION['name'];
                           // } ?>
                        </td>
                	</tr>
                	<tr>
                		<td>Tamanho do vídeo</td>
                		<td><?php // echo $vid_size." MB<br>"; ?></td>
                	</tr>
                	<tr>
                		<td>Formato original</td>
                		<td><?php //echo str_replace(".","","$vid_src"); ?></td>
                	</tr>
                    <tr>
                        <td>Novo formato</td>
                        <td><?php //echo $vid_new; ?></td>
                    </tr>

                    <tr>
                        <td>CLIQUE PARA VOLTAR</td>
                        <td><a href="http://holodroide.com/sistema/usuario/">HOME</a></td>
                    </tr>

                </table -->
			
			<?php
				
			echo "</center>";
			session_unset();

    		}else {

			?>

            <!---- jQuery-File-Upload begin ---->
            <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <!-- The jQuery UI widget factory, can be omitted if jQuery UI is already included -->
            <script src="js/vendor/jquery.ui.widget.js"></script>
            <!-- The Load Image plugin is included for the preview images and image resizing functionality -->
            <script src="//blueimp.github.io/JavaScript-Load-Image/js/load-image.all.min.js"></script>
            <!-- The Canvas to Blob plugin is included for image resizing functionality -->
            <script src="//blueimp.github.io/JavaScript-Canvas-to-Blob/js/canvas-to-blob.min.js"></script>
            <!-- Bootstrap JS is not required, but included for the responsive demo navigation -->
            <script src="//netdna.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
            <!-- The Iframe Transport is required for browsers without support for XHR file uploads -->
            <script src="js/jquery.iframe-transport.js"></script>
            <!-- The basic File Upload plugin -->
            <script src="js/jquery.fileupload.js"></script>
            <!-- The File Upload processing plugin -->
            <script src="js/jquery.fileupload-process.js"></script>
            <!-- The File Upload image preview & resize plugin -->
            <script src="js/jquery.fileupload-image.js"></script>
            <!-- The File Upload audio preview plugin -->
            <script src="js/jquery.fileupload-audio.js"></script>
            <!-- The File Upload video preview plugin -->
            <script src="js/jquery.fileupload-video.js"></script>
            <!-- The File Upload validation plugin -->
            <script src="js/jquery.fileupload-validate.js"></script>



            <!-- center class="panel panel-default" style="margin:0 auto;" -->

            <!-- div class="container" style="border:solid 3px #ff0;" -->
                <div class="row">
                    <div class="col-md-12" style="text-align:center;margin:20px 0 20px 0;">
                
                        <div style="max-width:270px; margin:0 auto;">
                        <script>
                        /*jslint unparam: true, regexp: true */
                        /*global window, $ */
                        $(function () {
                            'use strict';
                            // Change this to the location of your server-side upload handler:
                            var url = window.location.hostname === 'blueimp.github.io' ?
                                        '//jquery-file-upload.appspot.com/' : 'php/',
                                uploadButton = $('<button/>')
                                    .addClass('btn btn-primary')
                                    .prop('disabled', true)
                                    .text('Processing...')
                                    .on('click', function () {
                                        var $this = $(this),
                                            data = $this.data();
                                        $this
                                            .off('click')
                                            .text('Abortar')
                                            .on('click', function () {
                                                $this.remove();
                                                data.abort();
                                            });
                                        data.submit().always(function () {
                                            $this.remove();
                                        });
                                    });
                            $('#fileupload').fileupload({
                                url: url,
                                dataType: 'json',
                                autoUpload: false,
                                acceptFileTypes: /(\.|\/)(<?php foreach ($allowedExtensions as $value) { echo $value . "|"; }?>)$/i,
                                disableVideoPreview: true,
                                disableImagePreview: true,
                                maxFileSize: <?php echo $max_file_size_in_bytes ;?>,
                                // Enable image resizing, except for Android and Opera,
                                // which actually support image resizing, but fail to
                                // send Blob objects via XHR requests:
                                disableImageResize: /Android(?!.*Chrome)|Opera/
                                    .test(window.navigator.userAgent),
                                previewMaxWidth: 100,
                                previewMaxHeight: 100,
                                previewCrop: true
                            }).on('fileuploadadd', function (e, data) {
                                data.context = $('<div/>').appendTo('#files');
                                $.each(data.files, function (index, file) {
                                    var node = $('<span/>');
                                    if (!index) {
                                        node
                                            .append('<br>')
                                            .append(uploadButton.clone(true).data(data));
                                    }
                                    node.appendTo(data.context);
                                });
                            }).on('fileuploadprocessalways', function (e, data) {
                                // hide upload button abdul
                                $(".fileinput-button").hide();
                                var index = data.index,
                                    file = data.files[index],
                                    node = $(data.context.children()[index]);
                                if (file.preview) {
                                    node
                                        .prepend('<br>')
                                        .prepend(file.preview);
                                }
                                if (file.error) {
                                    node
                                        .append('<br>')
                                        .append($('<span class="text-danger"/>').text(file.error));
                                }
                                if (index + 1 === data.files.length) {
                                    data.context.find('button')
                                        .text('ENVIAR')
                                        .prop('disabled', !!data.files.error);
                                }
                            }).on('fileuploadprogressall', function (e, data) {
                                var progress = parseInt(data.loaded / data.total * 100, 10);
                                $('#progress .progress-bar').css(
                                    'width',
                                    progress + '%'
                                );
                            }).on('fileuploaddone', function (e, data) {
                                $.each(data.result.files, function (index, file) {
                                    if (file.url) {
                                        var link = $('<a>')
                                            .attr('class', 'btn-lg btn-primary ')
                                            .text('PRÓXIMO')
                                            .prop('href', 'index.php?uploaded_name=' + file.name);
                                        $(data.context.children()[index])
                                            .wrap(link);
                                    } else if (file.error) {
                                        var error = $('<span class="text-danger"/>').text(file.error);
                                        $(data.context.children()[index])
                                            .append('<br>')
                                            .append(error);
                                    }
                                });
                            }).on('fileuploadfail', function (e, data) {
                                $.each(data.files, function (index) {
                                    var error = $('<span class="text-danger"/>').text('File upload failed.');
                                    $(data.context.children()[index])
                                        .append('<br>')
                                        .append(error);
                                });
                            }).prop('disabled', !$.support.fileInput)
                                .parent().addClass($.support.fileInput ? undefined : 'disabled');
                        });

                        </script>

                        <div class="container-fluid" style="padding:0;">

                            <!-- The global progress bar -->
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>

                            <!-- The fileinput-button span is used to style the file input field as button -->
                            <span class="btn btn-success fileinput-button" style="width:100%;max-width:270px;">
                                <i class="glyphicon glyphicon-plus"></i>
                                <span>ESCOLHA UM VÍDEO</span>
                                <!-- The file input field used as target for the file upload widget -->
                                <input id="fileupload" type="file" name="files">
                            </span>

                            <!-- The container for the uploaded files -->
                            <div id="files" class="files button_next"></div>

                        </div>

                        <br>
                        <p class="size_limit bg-info">Tamanho máximo permitido <?php echo $max_file_size ;?> MB<p>
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

            <!-- /center -->

            <?php 
            }
            include("templates/footer.php");
            ?>