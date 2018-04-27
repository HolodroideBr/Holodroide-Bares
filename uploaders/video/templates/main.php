<?php include("templates/header_remote.php");
include ("includes/settings.php");
?>

<!-- Start Content Wrapper -->
<script>
function validateForm()
{
var x=document.forms["transload"]["link"].value;
if (x==null || x=="")
  {
  alert("You must add a link for the video");
  return false;
  }
}

</script>
<div id="contentWrapper">

<!-- Start Body Area -->
<div id="bodyArea">
    <div class="google_ads">

    </div>
<h1 class="headLeft" >Video Converter php script:</h1>

<div id="features">
<ul>
	<li>Convert all videos to MP4, MP3, etc. for various media players</li>
	<li>Extract audio from video like mp3 format</li>
	<li>Choose the video and the audio quality</li>
	<li>Upload video from your pc or a remote server</li>
</ul>
</div>
    <div class="google_ads">

    </div>
<div align="center" style="margin:0px">
<table align="center">
<tbody>
<tr>
<td valign="top">
<!--Stat r-sidebar , Put your content in this block-->

<!-- End r-sidebar -->
</td>
<td align="center" valign="top">
    <div class="panel panel-default">    
<h3 class="panel-heading">Upload a video file</h3>    
    <table id="tb_content" >
    <tbody>

    <td align="center">
        <p>Example to test</p>
        <br>
        <p class="text-info"> http://www.abdulibrahim.com/production/files/Cool_Contact_WordPress.mp4</p>
        <br>

    <form action="<?php echo $PHP_SELF; ?>" onsubmit="return validateForm()" name="transload" method="post"<?php if ($options['new_window']) { echo ' target="_blank"'; } ?>>

    <table class="tab-content" id="tb1" cellspacing="5" width="100%">
    <tbody>
    <tr>
    <td >
    <span class="middle"> <?php echo lang(207); ?>:</span></td>
    <td align="left">
    <input type="text" name="link" id="link" size="50" style="height:30px;"  /><br /><br />
    </td>
    <td align="center" width="130">
    <input type="submit" value="" id="send_bt" /></td>
    </tr>
    </tbody>
    </table>
    <?php
    if ($proxy)
      { ?>
      <input type="hidden" name="useproxy" value="on"  />
      <input type="hidden" name="proxy" value="<?php echo $proxy ?>"  />
      <input type="hidden" name="proxyuser" value="<?php echo $proxyuser ?>"  />
    <input type="hidden" name="proxypass" value="<?php echo $proxypass ?>"  />
    <?php
      }
      ?>
    <input type='hidden' name='yt_QS' value='on' />
    <input type='hidden' name='yt_fmt' value='18' />
    <input type='hidden' name='referer' id='QS_referer' value='http%3A%2F%2Fwww.youtube.com' />
    <input type='hidden' name='partSize' id='QS_partSize' value='10' />
    <input type='hidden' name='method' id='QS_method' value='tc' />
    <input type='hidden' name='ytube_mp4' id='QS_ytube_mp4' value='on' />
    </form>
        <br>
    <p class="size_limit bg-info">Maximum Remote URL size <?php echo ini_get("memory_limit") ;?> MB
    </p>
    </td>
    </tbody>
    </table>
</div>
</td>
</tr>
</tbody>
</table>
<?php include("templates/info.php");?>
<?php include("templates/footer.php");?>


