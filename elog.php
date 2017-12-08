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
	$tpfelog_folders = array($tpfelog_path . "error_log",
	 $tpfelog_path . "php_errorlog",
	 $tpfelog_path . "wp-admin/error_log",
	 $tpfelog_path . "wp-admin/php_errorlog",
	 $tpfelog_path . "wp-admin/includes/error_log",
	 $tpfelog_path . "wp-admin/includes/php_errorlog",
	 $tpfelog_path . "wp-admin/network/error_log",
	 $tpfelog_path . "wp-admin/network/php_errorlog",
	 $tpfelog_path . "wp-admin/user/error_log",
	 $tpfelog_path . "wp-admin/user/php_errorlog",
	 $tpfelog_path . "wp-includes/error_log",
	 $tpfelog_path . "wp-includes/php_errorlog",
	 $tpfelog_path . "wp-content/error_log",
	 $tpfelog_path . "wp-content/php_errorlog",
	 $tpfelog_path . "wp-content/plugins/error_log",
	 $tpfelog_path . "wp-content/plugins/php_errorlog",
	 $tpfelog_path . "wp-content/themes/error_log",
	 $tpfelog_path . "wp-content/themes/php_errorlog"
 );
 $tpfelog_plugins = array_slice(scandir($tpfelog_path . "wp-content/plugins"), 2);
foreach ($tpfelog_plugins as $tpfelog_plugin) {
	if(is_dir($tpfelog_path . "wp-content/plugins/" . $tpfelog_plugin)){
		array_push($tpfelog_folders, $tpfelog_path . "wp-content/plugins/" . $tpfelog_plugin . "/error_log");
		array_push($tpfelog_folders, $tpfelog_path . "wp-content/plugins/" . $tpfelog_plugin . "/php_errorlog");
	}
}
$tpfelog_themes = array_slice(scandir($tpfelog_path . "wp-content/themes"), 2);
foreach ($tpfelog_themes as $tpfelog_theme) {
 if(is_dir($tpfelog_path . "wp-content/themes/" . $tpfelog_theme)){
	 array_push($tpfelog_folders, $tpfelog_path . "wp-content/themes/" . $tpfelog_theme . "/error_log");
	 array_push($tpfelog_folders, $tpfelog_path . "wp-content/themes/" . $tpfelog_theme . "/php_errorlog");
 }
}

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
