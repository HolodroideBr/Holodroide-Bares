<?php
include ('includes/settings.php');
$delete_all_files = $delete_files*01*01;  // to delete after the number of hours

# to delete all files from the php/uploaded folder 
$files = glob('php/uploaded/*');

foreach($files as $file) {
if ( filemtime($file) <= time()-$delete_all_files ) {
    unlink($file);
	 }
}


# to delete all files from the log folder 
$files = glob('log/*');

foreach($files as $file) {
if ( filemtime($file) <= time()-$delete_all_files ) {
    unlink($file);
	 }
}


/*
# to delete all files from the converted_videos folder 
$files = glob('converted_videos/*');

foreach($files as $file) {
if ( filemtime($file) <= time()-$delete_all_files ) {
    unlink($file);
	 }
}
*/



?>
