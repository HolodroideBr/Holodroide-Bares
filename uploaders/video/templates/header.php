<?php
if (!isset($_SESSION)) 
{
  session_start();
}
// You can do some initialization for the template here
@date_default_timezone_set(date_default_timezone_get());
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link title="voottavar Style" href="templates/styles/rl_style_pm.css" rel="stylesheet" type="text/css" />

<title> Video Converter php script </title>
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

<!-- Top Bar -->

<!-- End Top Bar -->

<!-- Start Header -->
<div id="header">
 <img src="images/header.png" alt="video converter" title="video converter" />
<p id="header_p"> 

<a href="http://bit.ly/13GbRD7"><img src="images/buy.png" alt="Video Converter php script" title="Video Converter php script" /></a>
</p>

</div>
<!-- End Header -->

<!-- Start Menu Bar -->
<div id="menu">
  <table  cellspacing="0" cellpadding="0">
  <tr>
    <td><a href="index.php" title="Home" <?php if($pos = strpos($_SERVER["PHP_SELF"], "index.php")!==false) echo "class=\"first\""; ?>>PC UPLOAD</a></td>
    <td><a href="remote.php" title="Installation" <?php if($pos = strpos($_SERVER["PHP_SELF"], "remote.php")!==false) echo "class=\"first\""; ?>>Remote UPLOAD</a></td>
    <td><a href="contact.php" title="contact us" <?php if($pos = strpos($_SERVER["PHP_SELF"], "contact.php")!==false) echo "class=\"first\""; ?>>CONTACT US</a></td>
  </tr>
  </table>
</div>
<div  class="under_nav"></div>
<!-- End Menu Bar -->
