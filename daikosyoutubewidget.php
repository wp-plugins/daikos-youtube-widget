<?php
/*
Plugin Name: Daiko's YouTube Widget
Plugin URI: http://www.daikos.net/widgets/daikos-youtube-widget/
Description: Adds a sidebar widget to display random YouTube videos of your own choice. Make your own videolist in the widget-control-panel and/or add your favorite tag(s), user(s). Syntax: [YouTube ID]@[Title]<Line Brake>.
Author: Rune Fjellheim
Version: 1.1.8
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
			$newoptions[$number]['tags'] = strip_tags(stripslashes($_POST["daikos-youtube-tags-$number"]));
			$newoptions[$number]['users'] = strip_tags(stripslashes($_POST["daikos-youtube-users-$number"]));
			$newoptions[$number]['show'] = $_POST["daikos-youtube-show-$number"];
			$newoptions[$number]['slug'] = strip_tags(stripslashes($_POST["daikos-youtube-slug-$number"]));
		}
/*		if ($options[$number]['content']=='') {
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
*/
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
		<label for="daikos-youtube-content-<?php echo "$number"; ?>" title="IMPORTANT: No line brake (new line) after the last video!" style="width: 495px; height: 280px;display:block;">Videos [YouTubeID]@[TITLE]{Line brake}<textarea style="width: 470px; height: 240px;" id="daikos-youtube-content-<?php echo "$number"; ?>" name="daikos-youtube-content-<?php echo "$number"; ?>"><?php echo htmlspecialchars($options[$number]['content']); ?></textarea></label>
		<label for="daikos-youtube-tags-<?php echo "$number"; ?>" title="YouTube tag(s), separated by ," style="line-height:35px;display:block;">Feed from YouTube tag(s), separated by ,  : <input type="text" style="width: 202px;" id="daikos-youtube-tags-<?php echo "$number"; ?>" name="daikos-youtube-tags-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['tags']); ?>" /></label>
		<label for="daikos-youtube-users-<?php echo "$number"; ?>" title="YouTube user(s), separated by ," style="line-height:35px;display:block;">Feed from YouTube user(s), separated by ,: <input type="text" style="width: 202px;" id="daikos-youtube-users-<?php echo "$number"; ?>" name="daikos-youtube-users-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['users']); ?>" /></label>
		<label for="daikos-youtube-show-<?php echo "$number"; ?>"  title="Show only on specified page(s)/post(s)/category. Default is All" style="line-height:35px;">Display only on: <select name="daikos-youtube-show-<?php echo"$number"; ?>" id="daikos-youtube-show-<?php echo"$number"; ?>"><option label="All" value="all" <?php if ($allSelected){echo "selected";} ?>>All</option><option label="Home" value="home" <?php if ($homeSelected){echo "selected";} ?>>Home</option><option label="Post" value="post" <?php if ($postSelected){echo "selected";} ?>>Post(s)</option><option label="Page" value="page" <?php if ($pageSelected){echo "selected";} ?>>Page(s)</option><option label="Category" value="category" <?php if ($categorySelected){echo "selected";} ?>>Category</option></select></label> 
		<label for="daikos-youtube-slug-<?php echo "$number"; ?>"  title="Optional limitation to specific page, post or category. Use ID, slug or title." style="line-height:35px;">Slug/Title/ID: <input type="text" style="width: 150px;" id="daikos-youtube-slug-<?php echo "$number"; ?>" name="daikos-youtube-slug-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['slug']); ?>" /></label>
		<label for="daikos-youtube-help" title="You can get more help and instructionc on www.daikos.net!" style="line-height:25px;display:block;"><a href="http://www.daikos.net/widgets/daikos-youtube-widget/">Help</a></label>
		<input type="hidden" name="daikos-youtube-submit-<?php echo "$number"; ?>" id="daikos-youtube-submit-<?php echo "$number"; ?>" value="1" />
	<?php
	}

	function widget_daikos_youtube($args, $number = 1) {
		$dytwVersion = "Daiko's YouTube Widget v. 1.1.8";
		extract($args);
		$options = get_option('widget_daikos_youtube');
		$videoplayeroptions = get_option('widget_daikos_videoplayer');
		
		$title = $options[$number]['title'];
		$tags = str_replace(" ", "", $options[$number]['tags']);
		$tags = explode(",", $tags);
		$users = str_replace(" ", "", $options[$number]['users']);
		$users = explode(",", $users);

  		include_once (ABSPATH . WPINC . '/rss.php');
		$maxitems = 10;

		if (!empty($tags)) {
			foreach ($tags as $tag) {
				$feed = fetch_rss("http://www.youtube.com/rss/tag/".$tag.".rss");
				$items = array_slice($feed->items, 0, $maxitems);				
				foreach ($items as $item) {
					$item['link'] = str_replace("http://youtube.com/?v=", "", $item['link']);
					if ($videos ='') {
						$videofeed = $videofeed.$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
					else {
						$videofeed = $videofeed."\n".$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
				} 
			}
			
		}
		if (!empty($users)) {
			foreach ($users as $user) {
				$feed = fetch_rss("http://www.youtube.com/rss/user/".$user."/videos.rss");
				$items = array_slice($feed->items, 0, $maxitems);
				foreach ($items as $item) {
					$item['link'] = str_replace("http://youtube.com/?v=", "", $item['link']);
					if ($videos ='') {
						$videofeed = $videofeed.$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
					else {
						$videofeed = $videofeed."\n".$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}

				} 
			}

		}
		if ($options[$number]['content']!='' ||  !empty($videos)) {
			$videos = $videos."\n".$options[$number]['content'];
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
		foreach($videos as $key => $value) {                                    // Take out empty videos
			if (strlen($value) < 10) $value = "";
			if($value == "" || $value == " " || is_null($value)) {
				unset($videos[$key]);
			}
		}                               
		$videos = array_unique($videos);                                        // Take out duplicates
		$videos = array_values($videos);                                        // Reorder the array
		$count = $options[$number]['count'];                                    // Count the videos available
		$countvideos = count($videos);
		
		if ($count>$countvideos){$count=$countvideos;}							// Prevent user from trying to show more videos than are available
		$random = array_rand($videos, $count);                                  // Pick a random selection of videos
		for ($num=0; $num<$count; ++$num)  {                                    // Go through the list and establish the mediaID and title arrays
            $video[$num] = $videos[$random[$num]];
			$temp = explode("@", $video[$num]);
			$mediaID[$num] = $temp[0];
			$videotitle[$num] = $temp[1];
        }
		$show = $options[$number]['show'];                                      // Get the setting on where to show the widget
		$slug = $options[$number]['slug'];                                      // Optional Slug/Title/PageID on where to show it
		$showvideoplayer = $videoplayeroptions['show'];                         // Check the VideoPlayer Show and Slug
		$slugvideoplayer = $videoplayeroptions['slug'];
		$showplayer = false;
		
   		switch ($showvideoplayer) {                                             // Determine whether to use ThickBox or Daiko's VideoPlayer
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
		
		$format = $options[$number]['format'];                                  // What format to show the thumbnail images in
		if (is_active_widget('widget_daikos_videoplayer') && $showplayer) {
			$width = $videoplayeroptions['width'];                              // Format to play the video in
			if (empty($width)) $width = 200;
			$height = round($width*0.836);
			for ($i=0; $i<$count ;++$i) {
				$fulltext = $fulltext.'<div class="DYTWWrapperOuter'.$format.'"><div class="DYTWWrapperInner'.$format.'"><a onclick="var so = new SWFObject(\'http://www.youtube.com/v/'.$mediaID[$i].'&amp;autoplay=1\', \'DYTW'.$i.'\', \''.$width.'\', \''.$height.'\', \'8\', \'#336699\');so.addParam(\'wmode\', \'transparent\');'.$addParameter.' so.write(\'BigPlayer2\');" href="#BigPlayer2"><img src="http://img.youtube.com/vi/'.$mediaID[$i].'/default.jpg" alt="'.$videotitle[$i].'" title="'.$videotitle[$i].'"><div class="DYTWIcon'.$format.'"><img src="'.get_options("siteurl").'/wp-content/plugins/daikos-youtube-widget/play.png" alt="play" title="play" ></div></a></div></div>'; 
			}
			$fulltext = '<div class="DYTWContainer">'.$fulltext.'<div class="DYTWcredits"><a href="http://www.daikos.net" title="'.$dytwVersion.'">YouTube Widget by Daiko</a></div></div>';
		} 
		elseif (function_exists('daikos_thickbox'))  {
			$width = 500;
			$height = round($width*0.825);
			for ($i=0; $i<$count ;++$i) {
				$fulltext = $fulltext.'<div class="DYTWWrapperOuter'.$format.'"><div class="DYTWWrapperInner'.$format.'"><a onclick="var so = new SWFObject(\'http://www.youtube.com/v/'.$mediaID[$i].'&amp;autoplay=1\', \'DYTW'.$i.'\', \'100%\', \'98%\', \'8\', \'#336699\');so.addParam(\'wmode\', \'transparent\');'.$addParameter.' so.write(\'flashcontent\');" href="#TB_inline?height='.$height.'&amp;width='.$width.'&amp;inlineId=flashcontent" class="thickbox"><img src="http://img.youtube.com/vi/'.$mediaID[$i].'/default.jpg" alt="'.$videotitle[$i].'" title="'.$videotitle[$i].'"><div class="DYTWIcon'.$format.'"><img src="'.get_options("siteurl").'/wp-content/plugins/daikos-youtube-widget/play.png" alt="play" title="play" ></div></a></div></div>'; 
			}
			$fulltext = '<div class="DYTWContainer">'.$fulltext.'<div class="DYTWcredits"><a href="http://www.daikos.net" title="'.$dytwVersion.'">YouTube Widget by Daiko</a></div></div>';
		}
		else {
		   	$fulltext = "This widget requires that you activate <a href=\"".get_options('siteurl')."/wp-admin/plugins.php\">Daiko's ThickBox Plugin</a> or activate the <a href=\"".get_options('siteurl')."/wp-admin/widgets.php\">Daiko's VideoPlayer Widget</a>."; 
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
			
              echo "</div>"; ?>
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
			widget_daikos_youtube_register($options['number']);
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
<!-- This loads the required scripts for Daiko's YouTube Widget -->
<link rel="stylesheet" href="<?php get_option('siteurl'); ?>/wp-content/plugins/daikos-youtube-widget/dytw.css" type="text/css" media="screen" />
<script type="text/javascript" src="<?php get_option('siteurl'); ?>/wp-content/plugins/daikos-youtube-widget/js/swfobject.js"></script>
<!-- End of script load Daiko's YouTube Widget -->			
				 <?php
	}
	
	function widget_daikos_youtube_footer(){
				 ?>
<!-- This is a container for the ThickBox pop-up player in Daiko's YouTube Widget -->
<div id="BigPlayer" style="display: none;">
<div id="flashcontent">
Loading....
</div>
</div>
<!-- End of container for the ThickBox pop-up player in Daiko's YouTube Widget -->
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
			register_widget_control($name, $i <= $number ? 'widget_daikos_youtube_control' : /* unregister */ '', 490, 495, $i);
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
		$show = $options['show'];                                      			// Get the setting on where to show the widget
		$slug = $options['slug'];                                      			// Optional Slug/Title/PageID on where to show it
		if (empty($width)) $width = 200;
		$heigth = round($width*0.82352941);
        $number = 1;
		$tags = str_replace(" ", "", $youtubeoptions[$number]['tags']); 		
		$tags = explode(",", $tags);
		$users = str_replace(" ", "", $youtubeoptions[$number]['users']);
		$users = explode(",", $users);

  		include_once (ABSPATH . WPINC . '/rss.php');
		$maxitems = 10;

		if (!empty($tags)) {
			foreach ($tags as $tag) {
				$feed = fetch_rss("http://www.youtube.com/rss/tag/".$tag.".rss");
				$items = array_slice($feed->items, 0, $maxitems);
				foreach ($items as $item) {
					$item['link'] = str_replace("http://youtube.com/?v=", "", $item['link']);
					if ($videos ='') {
						$videofeed = $videofeed.$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
					else {
						$videofeed = $videofeed."\n".$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
				} 
			}
		}

		if (!empty($users)) {
			foreach ($users as $user) {
				$feed = fetch_rss("http://www.youtube.com/rss/user/".$user."/videos.rss");
				$items = array_slice($feed->items, 0, $maxitems);
				foreach ($items as $item) {
					$item['link'] = str_replace("http://youtube.com/?v=", "", $item['link']);
					if ($videos ='') {
						$videofeed = $videofeed.$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
					else {
						$videofeed = $videofeed."\n".$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
                } 
			}
		}

		if ($youtubeoptions[$number]['content']!='' ||  !empty($videos)) {
			$videos = $videos.$youtubeoptions[$number]['content'];
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
		foreach($videos as $key => $value) {                                    // Take out empty videos
			if (strlen($value) < 10) $value = "";
			if($value == "" || $value == " " || is_null($value)) {
				unset($videos[$key]);
			}
		}                               
		$videos = array_unique($videos);                                        // Take out duplicates
		$videos = array_values($videos);                                        // Reorder the array
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