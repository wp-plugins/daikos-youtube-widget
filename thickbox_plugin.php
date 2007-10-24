<?php
/*
Plugin Name: Daiko's ThickBox Plugin
Plugin URI: http://www.daikos.net/
Description: Adds <a href='http://jquery.com/demo/thickbox/'>Cody Lindley's</a> thickbox effects.
Version: 1.1 beta
Author: Rune Fjellheim
Author URI: http://www.daikos.net
*/

function daikos_thickbox() {
	$thickbox_path =  get_settings('siteurl')."/wp-content/plugins/daikos-youtube-widget/thickbox/";
	echo("<!-- Start Daiko's ThicBox Plugin -->");
	echo("<link rel='stylesheet' href='".$thickbox_path."thickbox.css' type='text/css' media='screen' />");
	echo("<script>jQuery.noConflict();</script><script type='text/javascript' src='".$thickbox_path."thickbox-compressed.js'></script>"); // The ThickBox script is made no-conflict ready by replacing $ with jQuery throughout the script otherwise standard ThickBox 3.1
	echo("<!-- End Daiko's ThicBox Plugin -->\n");
}

// Load the included jquery script via WP's script loading system to make sure it doesn't load more than once.
function daikos_thickbox_init() {
	if (function_exists('wp_enqueue_script')) {
		wp_enqueue_script('jquery');
	}
}
add_action('init', 'daikos_thickbox_init');
add_action('wp_head', 'daikos_thickbox');