<?php
/*
Plugin Name: elog
Plugin URI:  https://github.com/TomFlanders/elog
Description: error_log reader
Version:     0.6
Author:      Tom Flanders
Author URI:  http://tomflanders.com
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/** Create menu */
add_action( 'admin_menu', 'elog_menu' );

/** Create page */
function elog_menu() {
	add_menu_page( "elog", "elog", "manage_options", "elog display", 'my_plugin_options');
}

/** Add content to page */
function my_plugin_options() {
	$elog_root = $_SERVER['DOCUMENT_ROOT'];
	$elog_count = 0;
	foreach (glob("../error_log") as $elog_filename) {
		echo "<br/>$elog_filename<br/>\n";
		$elog_count++;
		echo "<pre>" . file_get_contents($elog_filename) . "</pre>";

	}
	foreach (glob("../*/error_log") as $elog_filename) {
		echo "<br/>$elog_filename<br/>\n";
		$elog_count++;
		echo "<pre>" . file_get_contents($elog_filename) . "</pre>";

	}
	foreach (glob("../*/*/error_log") as $elog_filename) {
		echo "<br/>$elog_filename<br/>\n";
		$elog_count++;
		echo "<pre>" . file_get_contents($elog_filename) . "</pre>";

	}
	foreach (glob("../*/*/*/error_log") as $elog_filename) {
		echo "<br/>$elog_filename<br/>\n";
		$elog_count++;
		echo "<pre>" . file_get_contents($elog_filename) . "</pre>";

	}
	echo "<p>Logs found: " . $elog_count . "</p>";
}

?>
