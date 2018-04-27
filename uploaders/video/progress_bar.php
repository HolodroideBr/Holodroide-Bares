<?php
if (!isset($_SESSION)) 
{
  session_start();
}?>
<script type="text/javascript">

var timer;
function countdown(remain, reset, linker){
	if (reset == true)clearInterval(timer);	
	var
		countdown = document.getElementById("redirecter")
		timer = setInterval( function () {
			countdown.innerHTML = Math.floor(remain/60) + ":" + (remain%60 < 10 ? "0": "") + remain %60;
			
			if (--remain < 0 ) { clearInterval(timer); window.location = linker;}
		},1000);
}
							
</script><?php


if(isset($_SESSION['name'])) {$time=$_SESSION['name'];}
//$file=$_SESSION['dest_file'].".".$_SESSION['type'];
if(isset($_SESSION['dest_file'])) {$file=$_SESSION['dest_file'];} else {$file="";}




if ( file_exists ($file) ) { echo "";} else {
/* This for debug to echo the $_SESSION varables
   foreach ($_SESSION as $key => $value) {
  echo '<p>'.$key.'</p>';
  echo '<p>'.$value.'</p>';
  foreach($value as $k => $v)
  {
  echo '<p>'.$k.'</p>';
  echo '<p>'.$v.'</p>';
  echo '<hr />';
  }

} 
*/
 
echo "<img src=\"images/error.png\" border=\"0\" /><br>";
echo "Sorry a problem occurred, there is no converted video in converted_videos folder! <br> Look at the log/ files!<br>";
echo "<a href=\"index.php\">"."<img src=\"images/red-back.png\" border=\"0\" /></a>";
$_SESSION['is_video_converted'] = "Error";
	/*************************  for debug        *************************************
	echo "<pre>";
	print_r ($_SESSION);
	echo "<pre>";
	**********************************************************************************/

 exit;}

if ( file_exists ( "log/" . $time. '.txt' ) ) 

{

// read log file ad search for words
// "muxing" overhed mean that video is succefuly finished
// "missing" is usualiy for missing codec

$logtext = file_get_contents("log/".$time.".txt", true);
$findme   =array ('missing', 'failed', 'incorrect', 'not found', 'Can not resample');
$finished = array ('muxing');
foreach($findme  as $value) 
	{

	  $pos = strpos($logtext, $value);
	  if ($pos === false) 
	  {
		$found=0;
		
		} 
	  else 
	  { 
	  	$found=1;
	  
	  }
	}
	
	
	foreach($finished  as $value2) 
	{

		  $pos = strpos($logtext, $value2);
		  if ($pos == true) 
		  {
			$status="finished";
			echo "<img src=\"images/done.png\" /><br><br>";
			echo "<b>Seu vídeo foi publicado com sucesso!</b><br>";
			$_SESSION['is_video_converted'] = "Yes";
					$_SESSION['is_video_converted']="Yes";			
					//echo "<br><a href=\"index.php?finished=true\" border=\"0\"><br><img src=\"images/next.png\" border=\"0\" /></a>";
					echo "<br><a href=\"index.php?finished=true\" border=\"0\" class=\"btn btn-danger\" style=\"width:100%;max-width:270px;font-size:0.800em;\">HOME</a>";
					?>
                    
                    
                    
                    
                    <!-- Faz com que vá direto ao REPORT (resultado detalhado da encodificação) -->
					<!-- <script> window.location = "index.php?finished=true" </script> -->
					
					
					
					
					
					<?php
					flush();
					
					if (isset($_GET['counter']))
						{
							if ($_GET['counter']==0)
								{ 
								echo "<script type=\"text/javascript\">window.location = \"index.php?finished=true\"</script>";
								}
							echo "<br>Redirecting in: ".$_GET['counter']." sec!";
						}					
					
					
					exit;
		
		  }
			
		
	 }
	if($found==0)
		{	
		require_once"video_duration.php";
					
		
		$urls="log/".$time.".txt";
		$page = join("",file("$urls"));
		$kw = explode("time=", $page);
		$last= array_pop($kw);
		$values=explode(' ', $last);
		
		$current_time_in_seconds=$values[0]; // to work with windows
        $pos = strpos($current_time_in_seconds , ":");
        if ($pos !== false) { 
        list($hours, $minutes, $seconds) = explode(":", $current_time_in_seconds); 
        $current_time_in_seconds=$hours*3600+$minutes*60+$seconds;
        }
         $current_time_in_seconds= round($current_time_in_seconds); // to work with windows
        //$current_time_in_seconds=round($values[0]);  won't work with windows
		/******************** to echo current time and video duration *************************
		echo "current_time_in_seconds" .$current_time_in_seconds."<br>";
        echo $time_in_seconds;
		**************************************************/
		$time_in_seconds=round($time_in_seconds);
		
		
		
		$procent_extracted= round((($current_time_in_seconds*100)/($time_in_seconds)));
					if($procent_extracted>100){$procent_extracted=100;}
					 
		?>
					
					<div style=" padding:1px; height:40px; width:224px; background-image:url(images/background.png); background-repeat:no-repeat; "><div id="loader_bar" style=" background-image:url(images/front.png); background-repeat:no-repeat; float:left; position:relative; left:2px; top:3px; height:30px; width:<?php echo $procent_extracted; ?>%"></div></div>
					
		<?php
		echo $procent_extracted."%";
		$values=array();
		$kw=array();
					
			echo "<br><br> <b>Um momento enquanto trabalhamos em seu vídeo</b> <br><br><br><img src=\"images/smiley-wait.png\" border=\"0\" /><br>";	
		}
	elseif($found==1) 
	{	echo "<img src=\"images/error.png\" border=\"0\" /><br>";
		echo "<br><br>oopps alguma coisa saiu errado, confira o arquivo de log / probably the codec is missing!<br><u>CONVERSÃO FALHOU!</u><br><br>Por favor tente um vídeo diferente!<br><br>status: conversão parou!";
		echo "<br><a href=\"index.php?finished=true\">"."<img src=\"images/done.png\" border=\"0\" /></a>";
		 
		$_SESSION['is_video_converted']="Error";
		exit;
		
	}
	


  
?>

<?php
exit;
} 



?>