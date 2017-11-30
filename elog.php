<?php
/*
Plugin Name: elog
Plugin URI:  https://github.com/TomFlanders/elog
Description: error_log reader
Version:     1.0.0
Author:      Tom Flanders
Author URI:  http://tomflanders.com
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/** Create menu */
add_action( 'admin_menu', 'tpfelog_menu' );

/** Create page */
function tpfelog_menu() {
	add_menu_page( "tpfelog", "elog", "manage_options", "elog display", 'tpfelog_options');
}

/** Add content to page */
function tpfelog_options() {
	$tpfelog_root = $_SERVER['DOCUMENT_ROOT'];
	$tpfelog_count = 0;
	$tpfelog_path = ABSPATH;
	$tpfelog_folders = array($tpfelog_path . "error_log", $tpfelog_path . "wp-*/error_log", $tpfelog_path . "wp-*/*/error_log", $tpfelog_path . "wp-*/*/*/error_log",$tpfelog_path . "php_errorlog", $tpfelog_path . "wp-*/php_errorlog", $tpfelog_path . "wp-*/*/php_errorlog", $tpfelog_path . "wp-*/*/*/php_errorlog");
	foreach($tpfelog_folders as $tpfelog_folder){
		foreach (glob($tpfelog_folder) as $tpfelog_filename) {
			if (strpos($tpfelog_filename, 'backup') != true) {
			echo "<br/>$tpfelog_filename<br/>";
			$tpfelog_count++;
			echo "<pre>" . file_get_contents($tpfelog_filename) . "</pre>";
			}
		}
	}
	echo "<p>Logs found: " . $tpfelog_count . "</p>";
}

?>
