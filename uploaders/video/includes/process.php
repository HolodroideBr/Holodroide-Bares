<?php
  include('../securimage/securimage.php');
  include('../includes/functions.php');
  include('../includes/LIB_mail.php');
  include('../includes/settings.php');
$securimage = new Securimage();
    $mail_addr['to'] = $email_to ;
    $mail_addr['from'] = $email_from ;
    $ipaddress = $_SERVER["REMOTE_ADDR"];

if (!empty($_POST)) { // the array is 5 the submit is counted
    stripslashes_array($_POST);
    $_POST=array_map("strip_tags",$_POST);
    extract($_POST, EXTR_PREFIX_SAME, "wddx"); //extract $_POST key to become variable name
    $name  .  $email  .  $Subject  .  $message.  $url ; //we got this from the form
           if (!empty($name) && !empty($email) && !empty($message)) {
               if ($securimage->check($_POST['captcha_code']) == false) { // check capcha
                   $result= "captcha";  // captcha is wrong
                   echo $result;
                    exit;
                  }
               if (filter_var($email, FILTER_VALIDATE_EMAIL)) { //  check email address format 
              $subject = " A new messsage from your site";
             $message = "Hello you have contact by the follwing persone<br>"
             . "<b>$name </b>"
             . "</br>The subject is </br><b> $Subject</b></br>"
             . "<b>The message is </b></br> $message<br>"
             . "he's email address is <b>$email</b></br>"
             . "he's website is <b>$url</b></br>"
             . "he's IP address is <b>$ipaddress</b>";
//formatted_mail($subject, $message, $mail_addr, "text/html");// send email to me to know there's a source has changed
            file_put_contents('../includes/results.html', $message);

    $result= "pass"; // it's ok
     echo $result;
                         }
                    }    
               
        }else{
            
            echo "fail";
        }
           
           
           


?>