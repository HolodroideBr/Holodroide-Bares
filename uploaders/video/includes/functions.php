<?php
// Removes the extension (and dot) of a filename
function RemoveExtension($filename) {
    $file = substr($filename, 0,strrpos($filename,'.'));   
    return $file;
    }
// create new name based on timestamp
function new_name()
	{
		$name=microtime();
		$name=str_replace(".","",$name);
		$name=str_replace(" ","",$name);
		return $name;
	}

//get video size

function get_size($vidname)

	{
		$size=filesize($vidname);
		$size=round($size/1024/1024, 2);
		return $size;
	}
	

function getRemoteFileSize($url){
   $parsed = parse_url($url);
   $host = $parsed["host"];
   $fp = fsockopen($host, 80, $errno, $errstr, 20);
   if(!$fp)return false;
   else {
       fputs($fp, "HEAD $url HTTP/1.1\r\n");
       fputs($fp, "HOST: $host\r\n");
       fputs($fp, "Connection: close\r\n\r\n");
       $headers = "";
       while(!feof($fp))$headers .= fgets ($fp, 128);
   }
   fclose ($fp);
   $return = false;
   $arr_headers = explode("\n", $headers);
   foreach($arr_headers as $header) {
       $s = "Content-Length: ";
       if(substr(strtolower ($header), 0, strlen($s)) == strtolower($s)) {
           $return = trim(substr($header, strlen($s)));
           break;
       }
   }
   if($return){
              $size = round($return / 1024, 2);
              $sz = "KB"; // Size In KB
        if ($size > 1024) {
            $size = round($size / 1024, 2);
            $sz = "MB"; // Size in MB
        }
        //echo "$size";
        
   }
   return $return;
}
function cron(){
#$file_path="http://".$_SERVER['SERVER_NAME']."/del-me-an.php";
$dir_path = str_replace(basename($_SERVER['PHP_SELF']),'',$_SERVER['PHP_SELF']);
$file_path="http://".$_SERVER['SERVER_NAME'].$dir_path."del-me-an.php";     
$ch = curl_init();
// set url
curl_setopt($ch, CURLOPT_URL, $file_path);
//return the transfer as a string
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 0);
// $output contains the output string
curl_exec($ch);
// close curl resource to free up system resources
curl_close($ch);
}
#########################
# get youtube details
# 8/2014
# edited 6/2015
########################
function get_youtube_id($video_id, $apikey ){
    $url = "https://www.googleapis.com/youtube/v3/videos?part=contentDetails&fields=items&id=$video_id&key=$apikey";
    $get_file = file_get_contents($url);
    //echo $get_file ;
    $get_json = json_decode($get_file);
    $item = $get_json->items ;
    $raw_duration = $item[0]->contentDetails->duration;
    $d = new DateInterval($raw_duration);
    $duration =  $d->format('%i'); // in minutes
    $image = "http://img.youtube.com/vi/$video_id/0.jpg";
return array($image, $duration); 
}
function get_last_url($link)  {
$last_http_postion = strripos($link, "f18");
$link_lenth =  strlen($link) ;
$source_link= substr($link,$last_http_postion+3 );
$source_link = str_replace(array("]","["), "", $source_link);
return   $source_link;

}
#### for contect abdul ####
    function stripslashes_array(&$arr) {
        foreach ($arr as $k => &$v) {
            $nk = stripslashes($k);
            if ($nk != $k) {
                $arr[$nk] = &$v;
                unset($arr[$k]);
            }
            if (is_array($v)) {
                stripslashes_array($v);
            } else {
                $arr[$nk] = stripslashes($v);
            }
        }
    }
?>