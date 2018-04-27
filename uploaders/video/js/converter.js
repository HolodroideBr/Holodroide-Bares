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
	function showStuff(id) {
		document.getElementById(id).style.display = 'block';
	}
	function ShowDiv()
{
document.getElementById("loading").style.display = '';
}
function checkform ( form )
{
  // see http://www.thesitewizard.com/archive/validation.shtml
  // for an explanation of this script and how to use it on your
  // own website

  // ** START **
  if (form.video_location.value == "") {
    alert( "Please enter your video location address." );
    form.video_location.focus();
    return false ;
  }
  // ** END **
  return true ;
}
//-->