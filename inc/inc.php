<?php
/**
*
*/
defined( 'ABSPATH' ) or die( 'Plugin file cannot be accessed directly.' );

function include_inc_directory() {

	$count = 0;
	$iterator = new RecursiveDirectoryIterator(dirname(__FILE__));
	
	foreach (new RecursiveIteratorIterator($iterator) as $filename => $file) {

		if ( (__FILE__ !== $filename) && ( strpos( $filename, 'php' ) >= 1 ) ) {

			$count++;
			include_once($filename);

		} //init

	} //forreach
	
	echo 'echo '.$count;

} //includes scripts