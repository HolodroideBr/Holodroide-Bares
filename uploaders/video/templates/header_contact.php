<head>

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link title="voottavar Style" href="templates/styles/rl_style_pm.css" rel="stylesheet" type="text/css" />

<title> contact us </title>
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
<link href="css/site.css" rel="stylesheet">
<style>

#contact label.error {
  font-size: 0.8em;
  color: #F00;
  font-weight: bold;
  display: block;
  margin-left: 215px;
}
#contact  input.error, #contact select.error  {
  background: #FFA9B8;
  border: 1px solid red;
}
#captcha_box{
width: 200px;
margin-left:220px;
margin-bottom: 15px
}

</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.0/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script>
$(document).ready(function() {
    // thank you box
                    jQuery(function() {
                    jQuery( "#thank_you" ).dialog({
                      autoOpen: false,
                      show: {
                        effect: "blind",
                        duration: 1000
                      },
                      hide: {
                        effect: "explode",
                        duration: 1000
                      }
                    });
                   });// end the thank you box 
               

 $('#contact').validate({
   
   rules: {
     name: {
        required: true,
        minlength:2
     },
        url: {
    url: true
     },
     email: {
        required: true,
        email: true
     },
     Subject: {        
        minlength:5
     },
     message: {
        required: true,
        minlength:15
     },	 
   }, //end rules
   messages: {
      name: {
         required: "Please supply Your name.",
         minlength: 'name must be at least 2 characters long.'
       },   
      email: {
         required: "Please supply an e-mail address.",
         email: "This is not a valid email address."
       },
      Subject: {
        required: 'Please type a subject',
        minlength: 'Subject must be at least 5 characters long.'
      },
      message: {
        required: 'Please type a message',
        minlength: 'message must be at least 10 characters long.'
      }	  
   }

  }); // end validate 

$('#contact').submit(function() {
   var formData = $(this).serialize();
        $.ajax({   // to post the form data
        type: "POST",
        url: 'includes/process.php',
        data: formData,
        success: processData // call back function
        

      });
     
      function processData(data) {
	console.log(data);
     //  var timedata = $.trim(data)
        if (data=='pass') {
            
               jQuery( "#thank_you" ).dialog({ position: { my: "center", at: "center", of: "#contact" } });
               jQuery( "#thank_you" ).dialog( "open" );
                         // after submission happen enable the submit button again
                         
             jQuery('input[type=submit]').val('Submitted');  
            
         //  $('#content').html('<p>The message has been received.<br> we will come back to you as soon as possible!</p>');
       }else if (data=='captcha') {
            $('#formwrapper').prepend('<p id="fail">Incorrect captcha</p>');
	  $('#fail').fadeOut(5000);
                         // if errors happen enable the submit button again
                         $('input[type=submit]').removeAttr('disabled');
                         $('input[type=submit]').val('submit');
        } else {
             $('#formwrapper').prepend('<p id="fail">Please fill in all the required fields.</p>');
			 $('#fail').fadeOut(5000);
                         // if errors happen enable the submit button again
                         $('input[type=submit]').removeAttr('disabled');
                         $('input[type=submit]').val('submit');
                   }
       } // end processData
       $('input[type=submit]').attr('disabled',true);
$('input[type=submit]').val('sending information...');
       return false;
// disable submission 


   }); // end submit
   
}); // end ready
</script>
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

