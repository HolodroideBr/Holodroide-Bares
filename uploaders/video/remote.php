<?php
// ini_set('display_errors', 0);
set_time_limit (0);
ini_alter ("memory_limit", "1024M");
@ob_end_clean ();
ob_implicit_flush (true);
error_reporting (6135);
$nn = "\r\n";
define ('ROOT_DIR', realpath ("./"));
define ('PATH_SPLITTER', (strstr (ROOT_DIR, "\\") ? "\\" : "/"));
define ('CLASS_DIR', 'classes/');
define ('CONFIG_DIR', 'configs/');
define ('HOST_DIR', 'hosts/');
//define('TEMPLATE_DIR', 'templates/youtube/');  // leave it
define ('DOWNLOAD_DIR', (substr ($options['download_dir'], 0, 6) == "ftp://" ? '' : $options['download_dir']));

//define ('TEMPLATE_DIR', 'templates/' . $options['template_used'] . '/');
require_once (CLASS_DIR . "other.php");
require_once (CLASS_DIR . "config.php");
if (! @file_exists (HOST_DIR . "download/hosts.php"))
{
	create_hosts_file ("download/hosts.php");
}

// require "hosts.php";
require_once (HOST_DIR . "download/hosts.php");
foreach ($_POST as $key => $value) //////// leave it
{
	$_GET [$key] = $value;
}

if (empty($_GET ["path"]))
{
	if (empty($_GET ["host"]))
	{
		$_GET ["path"] = (substr ($options['download_dir'], 0, 6) != "ftp://") ? realpath (DOWNLOAD_DIR) : $options['download_dir'];
	}
	else
	{
		$_GET ["saveto"] = (substr ($options['download_dir'], 0, 6) != "ftp://") ? realpath (DOWNLOAD_DIR) : $options['download_dir'];
	}
}
if (empty($_GET ["filename"]) || empty($_GET ["host"]) || empty($_GET ["path"]))
{
	$LINK = !empty($_GET ["link"]) ? trim (urldecode ($_GET ["link"])) : false;
	if (! $LINK)
	{
		require_once ("templates/main.php");
		exit ();
	}

	
	

	// Detect if it doesn't have a protocol assigned
	if (substr($LINK, 0, 7) != "http://" && substr($LINK, 0, 6) != "ftp://" && substr($LINK, 0, 6) != "ssl://" && substr($LINK, 0, 8) != "https://" && !stristr($LINK, '://'))
	{ 
		// Automatically assign http://
		$LINK = "http://" . $LINK;
	}
	$Url = parse_url ($LINK);

	$Url['path'] = str_replace('%2F', '/', rawurlencode(urldecode($Url['path'])));
	$LINK = rebuild_url($Url);

	if ($Url ['scheme'] != 'http' && $Url ['scheme'] != 'https' && $Url ['scheme'] != 'ftp')
	{
		html_error (lang(5));   // CHANGE LANG
	}
    			foreach ($host as $site => $file)
			{ 
				// if ($Url["host"] == $site)
				if (preg_match ("/^(.+\.)?" . str_replace('.', '\.', $site) . "$/i", $Url ["host"]))
				{

					//include(TEMPLATE_DIR . '/header.php');
					require_once (CLASS_DIR . "http.php");
					require_once (HOST_DIR . "DownloadClass.php");
					require_once (HOST_DIR . 'download/' . $file);
					$class = substr($file, 0, -4);
					$firstchar = substr($file, 0, 1);
					if ($firstchar > 0)
					{
						$class = "d" . $class;
					}
					if (class_exists($class))
					{
						$hostClass = new $class();
						$hostClass->Download($LINK);
					}
					exit ();
				}
			}

	$Url = parse_url ($LINK);
	$FileName = isset($Url ["path"]) ? basename ($Url ["path"]) : '';
	$mydomain = $_SERVER['SERVER_NAME'];
	$myip = $_SERVER['SERVER_ADDR'];


	insert_location ("$PHP_SELF?filename=" . urlencode ($FileName) . "&host=" . $Url ["host"] . "&port=" . (isset($Url ["port"]) ? $Url ["port"] : '') . "&path=" . (!empty($Url ["path"]) ? urlencode ($Url ["path"]) : '') . (!empty($Url ["query"]) ? urlencode("?" . $Url ["query"]) : "") . "&referer=" . urlencode ($Referer) . "&email=" . (!empty($_GET ["domail"]) ? $_GET ["email"] : "") . "&partSize=" . (!empty($_GET ["split"]) ? $_GET ["partSize"] : "") . "&method=" . (!empty($_GET ["method"]) ? $_GET ["method"] : '') . (!empty($_GET ["proxy"]) ? "&useproxy=on&proxy=".$_GET ["proxy"] : "") . "&saveto=" . $_GET ["path"] . "&link=" . urlencode ($LINK) . (isset($_GET ["add_comment"]) && $_GET ["add_comment"] == "on" && !empty($_GET ["comment"]) ? "&comment=" . urlencode ($_GET ["comment"]) : "") . $auth . ($pauth ? "&pauth=$pauth" : "") . (isset ($_GET ["audl"]) ? "&audl=doum" : "") . "&cookie=" . (!empty($_GET ["cookie"]) ? urlencode (encrypt ($_GET ['cookie'])) : '' . "&dis_plug=on"));
}
else
{
	include('templates/header.php');
	
	echo('<div align="center">');



	do
	{
		$_GET ["filename"] = urldecode (trim ($_GET ["filename"]));
		if (strstr($_GET ["filename"], '?') !== false) list ($_GET ["filename"], $tmp) = explode ('?', $_GET ["filename"], 2);
		$_GET ["saveto"] = urldecode (trim ($_GET ["saveto"]));
		$_GET ["host"] = urldecode (trim ($_GET ["host"]));
		$_GET ["path"] = urldecode (trim ($_GET ["path"]));
		$_GET ["port"] = !empty($_GET ["port"]) ? urldecode (trim ($_GET ["port"])) : 80;
		$_GET ["referer"] = !empty($_GET ["referer"]) ? urldecode (trim ($_GET ["referer"])) : 0;
		$_GET ["link"] = urldecode (trim ($_GET ["link"]));

		$_GET ["post"] = !empty($_GET ["post"]) ? unserialize (stripslashes (urldecode (trim ($_GET ["post"])))) : 0;
		$_GET ["cookie"] = !empty($_GET ["cookie"]) ? decrypt(urldecode(trim($_GET["cookie"]))) : "";
		$_GET ["proxy"] = !empty($_GET ["proxy"]) ? $_GET ["proxy"] : "";
		// $resume_from = $_GET["resume"] ? intval(urldecode(trim($_GET["resume"]))) : 0;
		// if ($_GET["resume"]) {unset($_GET["resume"]);}
		$redirectto = "";

		$pauth = !empty($_GET ["pauth"]) ? urldecode (trim ($_GET ["pauth"])) : '';

		$_GET['auth'] = isset($_GET['auth']) ? trim($_GET['auth']) : '';
		if ($_GET['auth'] == "1")
		{
			if (!preg_match("|^(?:.+\.)?(.+\..+)$|i", $_GET ["host"], $hostmatch)) html_error('No valid hostname found for authorisation!');
			$hostmatch = str_replace('.', '_', $hostmatch[1]);
		}
		else
		{
			$auth = $AUTH = false;
		}

		$pathWithName = $_GET ["saveto"] . PATH_SPLITTER . $_GET ["filename"];
		while (stristr ($pathWithName, "\\\\"))
		{
			$pathWithName = str_replace ("\\\\", "\\", $pathWithName);
		}

		if (strstr($pathWithName, '?') !== false) list ($pathWithName, $tmp) = explode ('?', $pathWithName, 2);

		$ftp = parse_url ($_GET ["link"]);
// i can add here chech extensions
			require_once (CLASS_DIR . "http.php");
			!empty($_GET ["force_name"]) ? $force_name = urldecode ($_GET ["force_name"]) : '';
			$file = geturl ($_GET ["host"], $_GET ["port"], $_GET ["path"], $_GET ["referer"], $_GET ["cookie"], $_GET ["post"], $pathWithName, $_GET ["proxy"], $pauth, $auth, $ftp ["scheme"]);
		

	}
	while ($redirectto && ! $lastError);

	if ($lastError)
	{
		html_error ($lastError, 0);
	}
	if ($file ["bytesReceived"] == $file ["bytesTotal"] || $file ["size"] == "Unknown")
	{
		echo '<script type="text/javascript">' . "pr(100, '" . $file ["size"] . "', '" . $file ["speed"] . "')</script>\r\n";
		// set download image and path
                
$filename = pathinfo($file ["file"], PATHINFO_FILENAME);
$file_extension = pathinfo($file ["file"], PATHINFO_EXTENSION);
// fix file names
$decodede_file_name = rawurldecode($filename);
$clean_file_name = preg_replace('/\W+/', '_', $decodede_file_name );
$full_old_name = $filename. '.' .$file_extension ;
$full_clean_name = $clean_file_name. '.' .$file_extension ;
// check if they are not equal to process it
if (strcmp($full_old_name, $full_clean_name) !== 0) {
    rename($store_dir.$full_old_name, $store_dir.$full_clean_name);
    $unlink_file = $store_dir.rawurldecode($full_old_name);
    if (file_exists($unlink_file)) {
        unlink($unlink_file);
    }
    $_SESSION['name'] = $clean_file_name;
}
$second="<img src=\"images/next.png\">";
/************* echo what file array contains ***********************************
print_r($file);
echo $original_name= return_between(basename($file['file']), '_', '.', 'INC') ;  // get the file name without the time()

********************************************************************************/

echo "<a href=\"index.php?uploaded_name=$full_clean_name\">$second</a>";
echo '</div>';
include ('templates/footer.php');

	}

	echo ('</div>');
	echo ('</body>');
	echo ('</html>');
}

?>
