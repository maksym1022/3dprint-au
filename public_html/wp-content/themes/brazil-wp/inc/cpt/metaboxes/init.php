<?php
$path = dirname(__FILE__);
$files = glob($path . '/*-init.php');

foreach($files as $file)
	if( __FILE__ != basename($file) )
		include_once $file;
		


 ?>