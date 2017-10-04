<?php
/*
Plugin Name: elog
Plugin URI:  https://github.com/TomFlanders/elog
Description: error_log reader
Version:     0.8.0
Author:      Tom Flanders
Author URI:  http://tomflanders.com
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/** Create menu */
add_action( 'admin_menu', 'elog_submenu' );

/** Create page */
function elog_submenu() {
    add_management_page( 'elog', 'elog', 'manage_options', 'display elog', 'elog_options' );
}

/** Add content to page */
function elog_options() {
	$elog_root = $_SERVER['DOCUMENT_ROOT'];
	$elog_count = 0;
	$elog_folders = array("../error_log", "../wp-*/error_log", "../wp-*/*/error_log", "../wp-*/*/*/error_log");
	foreach($elog_folders as $elog_folder){
		foreach (glob($elog_folder) as $elog_filename) {
			if (strpos($elog_filename, 'backup') != true) {
			echo "<br/>$elog_filename<br/>\n";
			$elog_count++;
			echo "<pre>" . file_get_contents($elog_filename) . "</pre>";
			}
		}
	}
	echo "<p>Logs found: " . $elog_count . "</p>";
}
?>
