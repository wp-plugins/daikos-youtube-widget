<?php
/*
Plugin Name: Daiko's YouTube Widget
Plugin URI: http://www.daikos.net/daikos-youtube-widget/
Description: Adds a sidebar widget to display random YouTube videos of your own choice.Make your own videolist in the widget-control-panel. Syntax: [YouTube ID]@[Title]<Line Brake>.
Author: Rune Fjellheim
Version: 1.0.5
License: GPL
Author URI: http://www.daikos.net
*/


function widget_daikos_youtube_init() {
                

	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	function widget_daikos_youtube_control($number) {
		$options = $newoptions = get_option('widget_daikos_youtube');
		if ( $_POST["daikos-youtube-submit-$number"] ) {
			$newoptions[$number]['title'] = strip_tags(stripslashes($_POST["daikos-youtube-title-$number"]));
			$newoptions[$number]['count'] = strip_tags(stripslashes($_POST["daikos-youtube-count-$number"]));
			$newoptions[$number]['format'] = strip_tags(stripslashes($_POST["daikos-youtube-format-$number"]));
			$newoptions[$number]['content'] = strip_tags(stripslashes($_POST["daikos-youtube-content-$number"]));
			$newoptions[$number]['show'] = $_POST["daikos-youtube-show-$number"];
			$newoptions[$number]['slug'] = strip_tags(stripslashes($_POST["daikos-youtube-slug-$number"]));
		}
		if ($options[$number]['content']=='') {
			$newoptions[$number]['content'] = 'FBSvtnCr8Wc@Transjoik - Gievrie
dF0kMBTwDrM@Transjoik - Mustai Amaia
vkG7psgdl1o@Sámigiella - an Arctic nature language - The Sami language
5OJPwCXsKFI@Radio and TV give vitality to the language - Electronic media
6AwZrJfyW5M@Master in our own house - The Finnmark Act
NzupjHuvACk@Yoik\'n Roll - Yoik/music
yCz-7Gnp1_M@Mun ja mun
zbeEEU_X_B0@Slincraze and Aimen with saami rap
t_xQN6s_COw@Sofia ja Anna - Du Calmmit (your eyes)
5eveNk3o1ME@VAJAS - Sparrow of the wind';
		}
   		if ($options[$number]['count']=='') {
 			$newoptions[$number]['count'] = 4;
		}				
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_daikos_youtube', $options);
		}
		$allSelected = $homeSelected = $postSelected = $pageSelected = $categorySelected = false;
		switch ($options[$number]['show']) {
			case "all":
			$allSelected = true;
			break;
			case "":
			$allSelected = true;
			break;
			case "home":
			$homeSelected = true;
			break;
			case "post":
			$postSelected = true;
			break;
			case "page":
			$pageSelected = true;
			break;
			case "category":
			$categorySelected = true;
			break;
		}
		$smallSelected = $mediumSelected = $largeSelected = false;
		switch ($options[$number]['format']) {
			case "small":
			$smallSelected = true;
			break;
			case "":
			$smallSelected = true;
			break;
			case "medium":
			$mediumSelected = true;
			break;
			case "large":
			$largeSelected = true;
			break;
		}
		    
	?>
		<label for="daikos-youtube-title-<?php echo "$number"; ?>" title="Title above the widget" style="line-height:35px;display:block;">Title: <input type="text" style="width: 442px;" id="daikos-youtube-title-<?php echo "$number"; ?>" name="daikos-youtube-title-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['title']); ?>" /></label>
		<label for="daikos-youtube-count-<?php echo "$number"; ?>" title="Number of videos to show" style="line-height:35px;">How many videos to show: <input type="integer" style="width: 80px;" id="daikos-youtube-count-<?php echo "$number"; ?>" name="daikos-youtube-count-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['count']); ?>" /></label>
		<label for="daikos-youtube-format-<?php echo "$number"; ?>"  title="Size of the thumbnails." style="line-height:35px;">Format: <select name="daikos-youtube-format-<?php echo "$number"; ?>" id="daikos-youtube-format-<?php echo "$number"; ?>"><option label="Small" value="small" <?php if ($smallSelected){echo "selected";} ?>>Small</option><option label="Medium" value="medium" <?php if ($mediumSelected){echo "selected";} ?>>Medium</option><option label="Large" value="large" <?php if ($largeSelected){echo "selected";} ?>>Large</option></select> </label>
		<label for="daikos-youtube-content-<?php echo "$number"; ?>" title="Insert your list of videos from YouTube separated by Line Brake. IMPORTANT: No Line Break after the last video!" style="width: 495px; height: 280px;display:block;">Videos [YouTube ID]@[TITLE]<textarea style="width: 470px; height: 240px;" id="daikos-youtube-content-<?php echo "$number"; ?>" name="daikos-youtube-content-<?php echo "$number"; ?>"><?php echo htmlspecialchars($options[$number]['content']); ?></textarea></label>
		<label for="daikos-youtube-show-<?php echo "$number"; ?>"  title="Show only on specified page(s)/post(s)/category. Default is All" style="line-height:35px;">Display only on: <select name="daikos-youtube-show-<?php echo"$number"; ?>" id="daikos-youtube-show-<?php echo"$number"; ?>"><option label="All" value="all" <?php if ($allSelected){echo "selected";} ?>>All</option><option label="Home" value="home" <?php if ($homeSelected){echo "selected";} ?>>Home</option><option label="Post" value="post" <?php if ($postSelected){echo "selected";} ?>>Post(s)</option><option label="Page" value="page" <?php if ($pageSelected){echo "selected";} ?>>Page(s)</option><option label="Category" value="category" <?php if ($categorySelected){echo "selected";} ?>>Category</option></select></label> 
		<label for="daikos-youtube-slug-<?php echo "$number"; ?>"  title="Optional limitation to specific page, post or category. Use ID, slug or title." style="line-height:35px;">Slug/Title/ID: <input type="text" style="width: 150px;" id="daikos-youtube-slug-<?php echo "$number"; ?>" name="daikos-youtube-slug-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['slug']); ?>" /></label>
		<label for="daikos-youtube-help" title="You can get more help and instructionc on www.daikos.net!" style="line-height:25px;display:block;"><a href="http://www.daikos.net/daikos-youtube-widget/">Help</a></label>
		<input type="hidden" name="daikos-youtube-submit-<?php echo "$number"; ?>" id="daikos-youtube-submit-<?php echo "$number"; ?>" value="1" />
	<?php
	}

	function widget_daikos_youtube($args, $number = 1) {
		$dytwVersion = "Daiko's YouTube Widget v. 1.0.5";
		extract($args);
		$options = get_option('widget_daikos_youtube');
		$videoplayeroptions = get_option('widget_daikos_videoplayer');
		
		$title = $options[$number]['title'];


		if ($options[$number]['content']!='') {
			$videos = $options[$number]['content'];
		}
		else {
			$videos = 'FBSvtnCr8Wc@Transjoik - Gievrie
dF0kMBTwDrM@Transjoik - Mustai Amaia
vkG7psgdl1o@Sámigiella - an Arctic nature language - The Sami language
5OJPwCXsKFI@Radio and TV give vitality to the language - Electronic media
6AwZrJfyW5M@Master in our own house - The Finnmark Act
NzupjHuvACk@Yoik\'n Roll - Yoik/music
yCz-7Gnp1_M@Mun ja mun
zbeEEU_X_B0@Slincraze and Aimen with saami rap
t_xQN6s_COw@Sofia ja Anna - Du Calmmit (your eyes)
5eveNk3o1ME@VAJAS - Sparrow of the wind';
		}

		$videos = explode("\n", $videos);										// First we make an array of the videolist
		$count = $options[$number]['count'];
		$countvideos = count($videos);
		if ($count>$countvideos){$count=$countvideos;}							// Prevent user from trying to show more videos than is available
		$random = array_rand($videos, $count); 
		for ($num=0; $num<$count; ++$num)  {
            $video[$num] = $videos[$random[$num]];
			$temp = explode("@", $video[$num]);
			$mediaID[$num] = $temp[0];
			$videotitle[$num] = $temp[1];
        }
		$show = $options[$number]['show'];                                      // Get the setting on where to show the widget
		$slug = $options[$number]['slug'];                                      // Optional Slug/Title/PageID on where to show it
		$showvideoplayer = $videoplayeroptions['show'];
		$slugvideoplayer = $videoplayeroptions['slug'];
		$showplayer = false;
		
   		switch ($showvideoplayer) {
				case "all": 
					$showplayer = true;
					break;
				case "home":
				if (is_home()) {
 					$showplayer = true;
		  		}
				break;
				case "post":
				if (is_single($slugvideoplayer)) {
					$showplayer = true;
		  		}
				break;
				case "page":
				if (is_page($slugvideoplayer)) {
					$showplayer = true;
		  		}
				break;
				case "category":
				if (is_category($slugvideoplayer)) {
					$showplayer = true;
		  		}
				break;
								
			}
		
		
		$format = $options[$number]['format'];
		if (is_active_widget('widget_daikos_videoplayer') && $showplayer) {
			$width = $videoplayeroptions['width'];
			if (empty($width)) $width = 200;
			$heigth = round($width*0.82352941);
			for ($i=0; $i<$count ;++$i) {
				$fulltext = $fulltext.'<div class="DYTWWrapperOuter'.$format.'"><div class="DYTWWrapperInner'.$format.'"><a onclick="var so = new SWFObject(\'http://www.youtube.com/v/'.$mediaID[$i].'&amp;autoplay=1\', \'DYTW'.$i.'\', \''.$width.'\', \''.$heigth.'\', \'8\', \'#336699\');so.addParam(\'wmode\', \'transparent\');'.$addParameter.' so.write(\'BigPlayer2\');" href="#"><img src="http://img.youtube.com/vi/'.$mediaID[$i].'/default.jpg" alt="'.$videotitle[$i].'" title="'.$videotitle[$i].'"><div class="DYTWIcon'.$format.'"><img src="http://localhost:8888/wp-content/plugins/daikos-youtube-widget/play.png" alt="play" ></div></a></div></div>'; 
			}
			$fulltext = '<div class="DYTWContainer">'.$fulltext.'<div class="DYTWcredits"><a href="http://www.daikos.net" title="'.$dytwVersion.'">YouTube Widget by Daiko</a></div></div>';
		} 
		elseif (function_exists('daikos_thickbox'))  {
			$width = 500;
			$heigth = round($width*0.82352941);
			for ($i=0; $i<$count ;++$i) {
				$fulltext = $fulltext.'<div class="DYTWWrapperOuter'.$format.'"><div class="DYTWWrapperInner'.$format.'"><a onclick="var so = new SWFObject(\'http://www.youtube.com/v/'.$mediaID[$i].'&amp;autoplay=1\', \'DYTW'.$i.'\', \'500\', \'375\', \'8\', \'#336699\');so.addParam(\'wmode\', \'transparent\');'.$addParameter.' so.write(\'flashcontent\');" href="#TB_inline?height=385&amp;width=500&amp;inlineId=flashcontent" class="thickbox"><img src="http://img.youtube.com/vi/'.$mediaID[$i].'/default.jpg" alt="'.$videotitle[$i].'" title="'.$videotitle[$i].'"><div class="DYTWIcon'.$format.'"><img src="http://localhost:8888/wp-content/plugins/daikos-youtube-widget/play.png" alt="play" ></div></a></div></div>'; 
			}
			$fulltext = '<div class="DYTWContainer">'.$fulltext.'<div class="DYTWcredits"><a href="http://www.daikos.net" title="'.$dytwVersion.'">YouTube Widget by Daiko</a></div></div>';
		}
		else {
		   	$fulltext = "This widget requires that you activate <a href=\"".get_bloginfo('url')."/wp-admin/plugins.php\">Daiko's ThickBox Plugin</a> or activate the <a href=\"".get_bloginfo('url')."/wp-admin/widgets.php\">Daiko's VideoPlayer Widget</a>."; 
		}
		
/* And do the widget dance! */
		?>
		<?php echo $before_widget; ?>
		<?php 
             echo "<div class='DaikosYouTube'>"; 
 
/* Do the conditional tag checks. */
   		switch ($show) {
				case "all": 
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
					break;
				case "home":
				if (is_home()) {
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		  		}
          		else {
            		echo "<!-- Daiko's YouTube Widget is disabled for this page/post! -->";
          		}
				break;
				case "post":
				if (is_single($slug)) {
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		  		}
          		else {
            		echo "<!-- Daiko's YouTube Widget is disabled for this page/post! -->";
          		}
				break;
				case "page":
				if (is_page($slug)) {
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		  		}
          		else {
            		echo "<!-- Daiko's YouTube Widget is disabled for this page/post! -->";
          		}
				break;
				case "category":
				if (is_category($slug)) {
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		  		}
          		else {
            		echo "<!-- Daiko's YouTube Widget is disabled for this page/post! -->";
          		}
				break;
								
			}
			
              echo ""; ?>
			<?php echo $after_widget."
			"; ?>
	
			<?php
	}

	function widget_daikos_youtube_setup() {
		$options = $newoptions = get_option('widget_daikos_youtube');
		if ( isset($_POST['daikos-youtube-number-submit']) ) {
			$number = (int) $_POST['daikos-youtube-number'];
			if ( $number > 9 ) $number = 9;
			if ( $number < 1 ) $number = 1;
			$newoptions['number'] = $number;
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_daikos_youtube', $options);
			widget_text_register($options['number']);
		}
	}
	
	function widget_daikos_youtube_page() {
		$options = $newoptions = get_option('widget_daikos_youtube');
	?>
		<div class="wrap">
			<form method="POST">
				<h2><?php _e("Daiko's YouTube Widgets", "widgets"); ?></h2>
				<p style="line-height: 30px;"><?php _e('How many YouTube widgets would you like?', 'widgets'); ?>
				<select id="daikos-youtube-number" name="daikos-youtube-number" value="<?php echo $options['number']; ?>">
	<?php for ( $i = 1; $i < 10; ++$i ) echo "<option value='$i' ".($options['number']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
				<span class="submit"><input type="submit" name="daikos-youtube-number-submit" id="daikos-youtube-number-submit" value="<?php _e('Save'); ?>" /></span></p>
			</form>
		</div>
	<?php
	} 
	
	function widget_daikos_youtube_head() {
   			 ?>
<link rel="stylesheet" href="<?php bloginfo('url'); ?>/wp-content/plugins/daikos-youtube-widget/dytw.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php bloginfo('url'); ?>/wp-content/plugins/daikos-youtube-widget/js/swfobject.js"></script>			
				 <?php
	}
	
	function widget_daikos_youtube_footer(){
				 ?>
<div id="BigPlayer" style="display: none;">
<!-- This is just a container for the video player in Daiko's YouTube Widget -->
<div id="flashcontent">
Loading....
</div>
</div>
		<?php
	}
	
	
	function widget_daikos_youtube_register() {
		$options = get_option('widget_daikos_youtube');
		$number = $options['number'];
		if ( $number < 1 ) $number = 1;
		if ( $number > 9 ) $number = 9;
		for ($i = 1; $i <= 9; $i++) {
			$name = array('Daiko\'s YouTube Widget %s', 'widgets', $i);
			register_sidebar_widget($name, $i <= $number ? 'widget_daikos_youtube' : /* unregister */ '', $i);
			register_widget_control($name, $i <= $number ? 'widget_daikos_youtube_control' : /* unregister */ '', 490, 455, $i);
		}
		add_action('sidebar_admin_setup', 'widget_daikos_youtube_setup');
		add_action('sidebar_admin_page', 'widget_daikos_youtube_page');
		if ( is_active_widget('widget_daikos_youtube') ) {
			add_action('wp_head', 'widget_daikos_youtube_head'); 
			add_action('wp_footer', 'widget_daikos_youtube_footer');
		}

	}
	
	
	add_action('init', 'widget_daikos_youtube_register', 5);
    
}
function widget_daikos_videoplayer_init() {

    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
        return; 

	    function widget_daikos_videoplayer_control() {
	        $options = $newoptions = get_option('widget_daikos_videoplayer');

	        if ( $_POST['daikos-videoplayer-submit'] ) {
	            $newoptions['title'] = strip_tags(stripslashes($_POST["daikos-videoplayer-title"]));
				$newoptions['width'] = strip_tags(stripslashes($_POST["daikos-videoplayer-width"]));
				$newoptions['show'] = $_POST["daikos-videoplayer-show"];
				$newoptions['slug'] = strip_tags(stripslashes($_POST["daikos-videoplayer-slug"]));
	        }

	        if ( $options != $newoptions ) {
	            $options = $newoptions;
	            update_option('widget_daikos_videoplayer', $options);
	        }
			$allSelected = $homeSelected = $postSelected = $pageSelected = $categorySelected = false;
			switch ($options['show']) {
				case "all":
				$allSelected = true;
				break;
				case "":
				$allSelected = true;
				break;
				case "home":
				$homeSelected = true;
				break;
				case "post":
				$postSelected = true;
				break;
				case "page":
				$pageSelected = true;
				break;
				case "category":
				$categorySelected = true;
				break;
			}

	        $title = $options['title'];
	        $width = $options['width'];

	?>
	        <div>
	        <label for="daikos-videoplayer-title" style="line-height:35px;display:block;">VideoPlayer title: <input type="text" id="daikos-videoplayer-title" name="daikos-videoplayer-title" value="<?php echo $title; ?>" /></label>
	        <label for="daikos-videoplayer-width" style="line-height:35px;display:block;">VideoPlayer width: <input type="integer" id="daikos-videoplayer-width" name="daikos-videoplayer-width" value="<?php echo $width; ?>" /></label>
			<label for="daikos-videoplayer-show"  title="Show only on specified page(s)/post(s)/category. Default is All" style="line-height:35px;display:block;">Display only on: <select name="daikos-videoplayer-show" id="daikos-videoplayer-show"><option label="All" value="all" <?php if ($allSelected){echo "selected";} ?>>All</option><option label="Home" value="home" <?php if ($homeSelected){echo "selected";} ?>>Home</option><option label="Post" value="post" <?php if ($postSelected){echo "selected";} ?>>Post(s)</option><option label="Page" value="page" <?php if ($pageSelected){echo "selected";} ?>>Page(s)</option><option label="Category" value="category" <?php if ($categorySelected){echo "selected";} ?>>Category</option></select></label> 
			<label for="daikos-videoplayer-slug"  title="Optional limitation to specific page, post or category. Use ID, slug or title." style="line-height:35px;">Slug/Title/ID: <input type="text" style="width: 150px;" id="daikos-videoplayer-slug" name="daikos-videoplayer-slug" value="<?php echo htmlspecialchars($options['slug']); ?>" /></label>
	        <input type="hidden" name="daikos-videoplayer-submit" id="daikos-videoplayer-submit" value="1" />
	        </div>
	    <?php
	    }

    function widget_daikos_videoplayer($args) {
        extract($args);
        $options = get_option('widget_daikos_videoplayer');
		$youtubeoptions = get_option('widget_daikos_youtube');
        $title = $options['title'];
        $width = $options['width'];
		$show = $options['show'];                                      // Get the setting on where to show the widget
		$slug = $options['slug'];                                      // Optional Slug/Title/PageID on where to show it
		if (empty($width)) $width = 200;
		$heigth = round($width*0.82352941);
        $number = 1;

		if ($youtubeoptions[$number]['content']!='') {
			$videos = $youtubeoptions[$number]['content'];
			}
		else {
			$videos = 'FBSvtnCr8Wc@Transjoik - Gievrie
dF0kMBTwDrM@Transjoik - Mustai Amaia
vkG7psgdl1o@Sámigiella - an Arctic nature language - The Sami language
5OJPwCXsKFI@Radio and TV give vitality to the language - Electronic media
6AwZrJfyW5M@Master in our own house - The Finnmark Act
NzupjHuvACk@Yoik\'n Roll - Yoik/music
yCz-7Gnp1_M@Mun ja mun
zbeEEU_X_B0@Slincraze and Aimen with saami rap
t_xQN6s_COw@Sofia ja Anna - Du Calmmit (your eyes)
5eveNk3o1ME@VAJAS - Sparrow of the wind';
		}

		$videos = explode("\n", $videos);										// First we make an array of the videolist
		$video = wptexturize( $videos[ mt_rand(0, count($videos) - 1 ) ] );
		$temp = explode("@", $video);
		$mediaID = $temp[0];
        $videocode = "<script>
var so = new SWFObject('http://www.youtube.com/v/".$mediaID."', 'DYTWBigPlayer', '".$width."', '".$heigth."', '8', '#336699');
so.addParam('wmode', 'transparent');
so.write('BigPlayer2');
</script>";
        $fulltext ="<!-- This is just a container for the big video player in Daiko\'s YouTube Widget -->
        <div id=\"BigPlayer2\">
		</div>
		".$videocode;
		
		echo $before_widget; 
		/* Do the conditional tag checks. */
		   		switch ($show) {
						case "all": 
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
							break;
						case "home":
						if (is_home()) {
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
				  		}
		          		else {
		            		echo "<!-- Daiko's VideoPlayer is disabled for this page/post! -->";
		          		}
						break;
						case "post":
						if (is_single($slug)) {
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
				  		}
		          		else {
		            		echo "<!-- Daiko's VideoPlayer is disabled for this page/post! -->";
		          		}
						break;
						case "page":
						if (is_page($slug)) {
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
				  		}
		          		else {
		            		echo "<!-- Daiko's VideoPlayer is disabled for this page/post! -->";
		          		}
						break;
						case "category":
						if (is_category($slug)) {
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
				  		}
		          		else {
		            		echo "<!-- Daiko's VideoPlayer is disabled for this page/post! -->";
		          		}
						break;

					}

		              echo ""; ?>
					<?php echo $after_widget."
					"; ?> 
					<?php
    }

    register_sidebar_widget('Daiko\'s VideoPlayer', 'widget_daikos_videoplayer');
    register_widget_control('Daiko\'s VideoPlayer', 'widget_daikos_videoplayer_control');
}

add_action('plugins_loaded', 'widget_daikos_youtube_init'); 
add_action('plugins_loaded', 'widget_daikos_videoplayer_init');
?>