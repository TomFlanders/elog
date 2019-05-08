<?php
/*
Plugin Name: elog
Plugin URI:  https://github.com/TomFlanders/elog
Description: error_log reader
Version:     1.2.0
Author:      Tom Flanders
Author URI:  http://tomflanders.com
License:     GPL3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

/** Create menu */
add_action( 'admin_menu', 'tpfelog_menu' );

/** Create page */
function tpfelog_menu() {
	add_menu_page( "elog", "elog", "manage_options", "elog display", 'tpfelog_options');
}

/** Add content to page */
function tpfelog_options() {
	$tpfelog_count = 0;
	$tpfelog_path = ABSPATH;
	$tpfelog_pluginsPath = substr(plugin_dir_path(__FILE__), 0, -6);
	$tpfelog_themePath = get_theme_root();
	$tpfelog_folders = array($tpfelog_path . "error_log",
  $tpfelog_path . "php_errorlog",
	$tpfelog_pluginsPath . "/error_log",
	$tpfelog_pluginsPath . "/php_errorlog",
	$tpfelog_themePath . "/error_log",
	$tpfelog_themePath . "/php_errorlog"
 );
 $tpfelog_admin_path = str_replace( get_bloginfo( 'url' ) . '/', ABSPATH, get_admin_url() );
 array_push($tpfelog_folders, $tpfelog_admin_path . "error_log");
 array_push($tpfelog_folders, $tpfelog_admin_path . "php_errorlog");

 $tpfelog_include_path = str_replace( get_bloginfo( 'url' ) . '/', ABSPATH, '/home/tomfland/public_html/' );
 array_push($tpfelog_folders, $tpfelog_include_path . "wp-includes/error_log");
 array_push($tpfelog_folders, $tpfelog_include_path . "wp-includes/php_errorlog");

/* Check each plugin */
 $tpfelog_plugins = array_slice(scandir($tpfelog_pluginsPath), 2);
foreach ($tpfelog_plugins as $tpfelog_plugin) {
	if(is_dir($tpfelog_pluginsPath . "/" . $tpfelog_plugin)){
		array_push($tpfelog_folders, $tpfelog_pluginsPath . "/" . $tpfelog_plugin . "/error_log");
		array_push($tpfelog_folders, $tpfelog_pluginsPath . "/" . $tpfelog_plugin . "/php_errorlog");
	}
}

/* check each theme */
$tpfelog_themes = array_slice(scandir($tpfelog_themePath), 2);
foreach ($tpfelog_themes as $tpfelog_theme) {
 if(is_dir($tpfelog_themePath . "/" . $tpfelog_theme)){
	 array_push($tpfelog_folders, $tpfelog_themePath . "/" . $tpfelog_theme . "/error_log");
	 array_push($tpfelog_folders, $tpfelog_themePath . "/" . $tpfelog_theme . "/php_errorlog");
 }
}

/* display files found */
	foreach($tpfelog_folders as $tpfelog_folder){
//		echo "<p>" . $tpfelog_folder . "</p>";
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
