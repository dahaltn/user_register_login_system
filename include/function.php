<?php

function display_errors($errors=array()){
	$output = '';
	foreach ($errors as $error) {
		$output .= "<p class=\"errors\">".$error."</p>";
	}
	echo $output;

}

//autoload class when object created
function load_class($class){
	return require_once("classes".DIRECTORY_SEPARATOR.strtolower($class).".class.inc.php");
}
spl_autoload_register('load_class');


?>