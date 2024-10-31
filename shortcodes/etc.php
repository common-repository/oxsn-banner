<?php


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


//[oxsn_banner page_id="" class=""]
if ( ! function_exists ( 'oxsn_banner_shortcode' ) ) {

	add_shortcode('oxsn_banner', 'oxsn_banner_shortcode');
	function oxsn_banner_shortcode( $atts, $content = null ) {
		$content = shortcode_unautop(trim($content));
		$a = shortcode_atts( array(
			'class' => '',
			'page_id' => '',
		), $atts );

		$oxsn_banner_class = esc_attr($a['class']);

		$oxsn_banner_page_id = esc_attr($a['page_id']);

		if ($oxsn_banner_page_id != "") :

			$ID = $oxsn_banner_page_id;

		else :

			$ID = get_the_id();

		endif;

		$oxsn_banner_url = get_post_meta( $ID, 'oxsn_banner_url', true );
		$oxsn_banner_parent_id = array_pop(get_post_ancestors($ID));
		$oxsn_banner_parent_url = get_post_meta( $oxsn_banner_parent_id, 'oxsn_banner_url', true );

		$oxsn_banner_default_url = esc_url( get_theme_mod( 'oxsn_banner_default_control' ) );
		$oxsn_banner_blog_url = esc_url( get_theme_mod( 'oxsn_banner_blog_control' ) );
		$oxsn_banner_search_url = esc_url( get_theme_mod( 'oxsn_banner_search_control' ) );
		$oxsn_banner_error_url = esc_url( get_theme_mod( 'oxsn_banner_error_control' ) );

		if ( !empty($oxsn_banner_url) ) :

			if (strpos($oxsn_banner_url, '.mp4') > 0 || strpos($oxsn_banner_url, '.webm') > 0 || strpos($oxsn_banner_url, '.ogv') > 0 || strpos($oxsn_banner_url, '.ogg') > 0) :

				if (strpos($oxsn_banner_url, '.mp4') > 0) :

					$oxsn_banner_url_mp4 = '<source src="' . $oxsn_banner_url . '" type="video/mp4">';

				elseif (strpos($oxsn_banner_url, '.webm') > 0) :

					$oxsn_banner_url_webm = '<source src="' . $oxsn_banner_url . '" type="video/webm">';

				elseif (strpos($oxsn_banner_url, '.ogv') > 0 || strpos($oxsn_banner_url, '.ogg') > 0) :

					$oxsn_banner_url_ogg = '<source src="' . $oxsn_banner_url . '" type="video/ogg">';

				endif;

				$option .=
				'<div class="oxsn_banner ' . $oxsn_banner_class . '">' .
					do_shortcode($content) .
					'<video class="oxsn_banner_video_bg" autoplay loop poster="" muted>' .
						$oxsn_banner_url_mp4 .
						$oxsn_banner_url_webm .
						$oxsn_banner_url_ogg .
					'</video>' .
				'</div>';

			elseif (strpos($oxsn_banner_url, 'youtube') > 0) :

				parse_str( parse_url( $oxsn_banner_url, PHP_URL_QUERY ), $my_array_of_vars );
				$oxsn_youtube_banner_code =  $my_array_of_vars['v'];

				$option .=
				'<div class="oxsn_banner ' . $oxsn_youtube_banner_class . '">' .
					do_shortcode($content) .
					'<div id="ytplayer" class="oxsn_banner_video_bg" youtubeid="' . $oxsn_youtube_banner_code . '"></div>' .
					'<script>var tag = document.createElement(\'script\'); tag.src = "https://www.youtube.com/player_api"; var firstScriptTag = document.getElementsByTagName(\'script\')[0]; firstScriptTag.parentNode.insertBefore(tag, firstScriptTag); var player; function onYouTubePlayerAPIReady() { player = new YT.Player(\'ytplayer\', { playerVars: { \'autoplay\': 1, \'controls\': 0, \'autohide\': 1, \'wmode\': \'opaque\', \'showinfo\': 0, \'loop\': 1, \'mute\': 1, \'playlist\': \'' . $oxsn_youtube_banner_code . '\' }, videoId: \'' . $oxsn_youtube_banner_code . '\', events: { \'onReady\': onPlayerReady } }); } function onPlayerReady(event) { event.target.mute().setLoop(true); }</script>' .
				'</div>';

			elseif (strpos($oxsn_banner_url, 'vimeo') > 0) :

				preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $oxsn_banner_url, $output_id);
				$oxsn_vimeo_banner_code = $output_id[5];

				$option .=
				'<div class="oxsn_banner ' . $oxsn_vimeo_banner_class . '">' .
					do_shortcode($content) .
					'<iframe id="vmplayer" class="oxsn_banner_video_bg" src="//player.vimeo.com/video/' . $oxsn_vimeo_banner_code . '?badge=0&byline=0&title=0&portrait=0&autoplay=1&loop=1&background=1&api=1&player_id=vmplayer" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>' .
					'<script>(function($) { $(document).ready(function(){ var froogaloop = \'https://f.vimeocdn.com/js/froogaloop2.min.js\'; $.getScript(froogaloop, function() { var vimeo_iframe = $(\'#vmplayer\')[0]; var player = $f(vimeo_iframe); player.addEvent(\'ready\', function() { player.api(\'setVolume\', 0); }); }); }); })(jQuery);</script>' .
				'</div>';

			else :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_url . ')"></div>' . '</div>';

			endif;

		elseif ( !empty($oxsn_banner_parent_id) && !empty($oxsn_banner_parent_url) ) :

			if (strpos($oxsn_banner_parent_url, '.mp4') > 0 || strpos($oxsn_banner_parent_url, '.webm') > 0 || strpos($oxsn_banner_parent_url, '.ogv') > 0 || strpos($oxsn_banner_parent_url, '.ogg') > 0) :

				if (strpos($oxsn_banner_parent_url, '.mp4') > 0) :

					$oxsn_banner_parent_url_mp4 = '<source src="' . $oxsn_banner_parent_url . '" type="video/mp4">';

				elseif (strpos($oxsn_banner_parent_url, '.webm') > 0) :

					$oxsn_banner_parent_url_webm = '<source src="' . $oxsn_banner_parent_url . '" type="video/webm">';

				elseif (strpos($oxsn_banner_parent_url, '.ogv') > 0 || strpos($oxsn_banner_parent_url, '.ogg') > 0) :

					$oxsn_banner_parent_url_ogg = '<source src="' . $oxsn_banner_parent_url . '" type="video/ogg">';

				endif;

				$option .=
				'<div class="oxsn_banner ' . $oxsn_banner_class . '">' .
					do_shortcode($content) .
					'<video class="oxsn_banner_video_bg" autoplay loop poster="" muted>' .
						$oxsn_banner_url_mp4 .
						$oxsn_banner_url_webm .
						$oxsn_banner_url_ogg .
					'</video>' .
				'</div>';

			elseif (strpos($oxsn_banner_parent_url, 'youtube') > 0) :

				parse_str( parse_url( $oxsn_banner_parent_url, PHP_URL_QUERY ), $my_array_of_vars );
				$oxsn_youtube_banner_code =  $my_array_of_vars['v'];

				$option .=
				'<div class="oxsn_banner ' . $oxsn_youtube_banner_class . '">' .
					do_shortcode($content) .
					'<div id="ytplayer" class="oxsn_banner_video_bg" youtubeid="' . $oxsn_youtube_banner_code . '"></div>' .
					'<script>var tag = document.createElement(\'script\'); tag.src = "https://www.youtube.com/player_api"; var firstScriptTag = document.getElementsByTagName(\'script\')[0]; firstScriptTag.parentNode.insertBefore(tag, firstScriptTag); var player; function onYouTubePlayerAPIReady() { player = new YT.Player(\'ytplayer\', { playerVars: { \'autoplay\': 1, \'controls\': 0, \'autohide\': 1, \'wmode\': \'opaque\', \'showinfo\': 0, \'loop\': 1, \'mute\': 1, \'playlist\': \'' . $oxsn_youtube_banner_code . '\' }, videoId: \'' . $oxsn_youtube_banner_code . '\', events: { \'onReady\': onPlayerReady } }); } function onPlayerReady(event) { event.target.mute().setLoop(true); }</script>' .
				'</div>';

			elseif (strpos($oxsn_banner_parent_url, 'vimeo') > 0) :

				preg_match("/(https?:\/\/)?(www\.)?(player\.)?vimeo\.com\/([a-z]*\/)*([0-9]{6,11})[?]?.*/", $oxsn_banner_parent_url, $output_id);
				$oxsn_vimeo_banner_code = $output_id[5];

				$option .=
				'<div class="oxsn_banner ' . $oxsn_vimeo_banner_class . '">' .
					do_shortcode($content) .
					'<iframe id="vmplayer" class="oxsn_banner_video_bg" src="//player.vimeo.com/video/' . $oxsn_vimeo_banner_code . '?badge=0&byline=0&title=0&portrait=0&autoplay=1&loop=1&background=1&api=1&player_id=vmplayer" width="500" height="281" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>' .
					'<script>(function($) { $(document).ready(function(){ var froogaloop = \'https://f.vimeocdn.com/js/froogaloop2.min.js\'; $.getScript(froogaloop, function() { var vimeo_iframe = $(\'#vmplayer\')[0]; var player = $f(vimeo_iframe); player.addEvent(\'ready\', function() { player.api(\'setVolume\', 0); }); }); }); })(jQuery);</script>' .
				'</div>';

			else :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_parent_url . ')"></div>' . '</div>';

			endif;

		elseif (is_front_page()) : 

			if ( !empty($oxsn_banner_blog_url) ) :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_blog_url . ')"></div>' . '</div>';

			elseif ( !empty($oxsn_banner_default_url) ) :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_default_url . ')"></div>' . '</div>';

			endif;

		elseif (is_search()) : 

			if ( !empty($oxsn_banner_search_url) ) :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_search_url . ')"></div>' . '</div>';

			elseif ( !empty($oxsn_banner_default_url) ) :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_default_url . ')"></div>' . '</div>';
			
			endif;

		elseif (is_404()) : 

			if ( !empty($oxsn_banner_error_url) ) :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_error_url . ')"></div>' . '</div>';

			elseif ( !empty($oxsn_banner_default_url) ) :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_default_url . ')"></div>' . '</div>';
			
			endif;

		else :

			if ( !empty($oxsn_banner_default_url) ) :

				$option = '<div class="oxsn_banner ' . $oxsn_banner_class . '">' . do_shortcode($content) . '<div class="oxsn_banner_image_bg" style="background-image: url(' . $oxsn_banner_default_url . ')"></div>' . '</div>';

			endif;

		endif;

		return $option;

	}

}


?>