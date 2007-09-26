<?php
/*
Plugin Name: Daiko's ThickBox Plugin
Plugin URI: http://www.daikos.net/
Description: Adds <a href='http://jquery.com/demo/thickbox/'>Cody Lindley's</a> thickbox effects.
Version: 1.0
Author: Rune Fjellheim
Author URI: http://www.daikos.net
*/

function daikos_thickbox() {
	$thickbox_path =  get_settings('siteurl')."/wp-content/plugins/daikos-youtube-widget/thickbox/";
	echo("<!-- Start Daiko's ThicBox Plugin -->
<link rel='stylesheet' href='".$thickbox_path."thickbox.css' type='text/css' media='screen' />
<script type='text/javascript' src='".$thickbox_path."jquery.js'></script>
<script type='text/javascript' src='".$thickbox_path."thickbox.js'></script>
<!-- End Daiko's ThicBox Plugin -->\n");
}

add_action('wp_head', 'daikos_thickbox');
?>