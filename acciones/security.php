<?php 
function prepare($var) {
	return addslashes(htmlentities($var,ENT_QUOTES));
}
function undo($var) {
	return (htmlspecialchars_decode (stripslashes($var),ENT_QUOTES));
}
?>