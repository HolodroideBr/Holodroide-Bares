<?php
  	include("DBTools.php");
	$link=dbConnect();

	$name = safe($_POST['name']);
	$pass = safe($_POST['pass']);



	$query = "SELECT * FROM 'tbl_usr' WHERE email_usr = '". $name ."'";
    $result = mysql_query($query) or die('Query failed: ' . mysql_error());	
    $num_results = mysql_num_rows($result);  
	
    if($num_results > 0)
    {
		$row = mysql_fetch_assoc($result);

				echo $name;

    }
	else
	{
		echo 'false';
	}
?>