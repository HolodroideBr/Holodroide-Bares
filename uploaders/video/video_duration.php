<?php
if(isset($_SESSION['name'])) {$time=$_SESSION['name'];}
$duration = file_get_contents("log/".$time.".txt");
$findme ="Duration";

$pos = strpos($duration , $findme);
if ($pos !== false) { 
      
      
           $search='/Duration: (.*?)[.]/';
$duration=preg_match($search, $duration, $matches, PREG_OFFSET_CAPTURE);
$duration = $matches[1][0];

//list($hours, $mins, $secs) = split('[:]', $logtext);

//echo $logtext;

list($hours, $minutes, $seconds) = explode(":", $duration);
        /*echo "<br>hours: ".$hours;
        echo "<br>minutes: ".$minutes;
        echo "<br>sec: ".$seconds;*/
        
    $time_in_seconds=$hours*3600+$minutes*60+$seconds;
          
        } 
      else 
      { 
      echo "Erro! Não foi possível determinar a duração do video!";
      
      }

?>