<?php

$dbName = 'holodroi_admin';
$host = 'localhost';
$username = 'holodroi_admin';
$password = 'SA9lscv2Dz9w';

$secretGameKey = "12345";
$secretServerKey = "54321";

function dbConnect()
{
	global  $dbName;
	global  $host;
	global  $username;
	global  $password;

	$link = mysql_connect($host, $username, $password);
	
	if(!$link)
	{
		fail("Couldn't connect to database server");
	}
	
	if(!@mysql_select_db($dbName))
	{
		fail("Couldn't find database $dbName");
	}
	
	return $link;
}
	
function safe($variable)
{
	$variable = addslashes(trim($variable));
	return $variable;
}

function fail($errorMsg)
{
	print $errorMsg;
	exit;
}

?>