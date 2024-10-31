<?php

function SE_AP_print_player($album_post_id, $downloadable, $cover){
	
	if($album_post_id != 'autoplayer'){
		$cover_img_src = SE_AP_get_album_cover($album_post_id);
	
		$album_post = get_post($album_post_id);

		$album_title = apply_filters('the_title', $album_post->the_title);
		$tracks = SE_AP_get_album_tracks($album_post_id);
	} else {
		global $post;
		
		$cover_img_src = $cover;

		
		$MP3dubQ_pattern = '/<a.*?href="(?P<url>.*?\.mp3(?:\?.*?)?)">(?P<title>.*?)<\/a>/Ui';
		$MP3singQ_pattern = "/<a.*?href='(?P<url>.*?\.mp3(?:\?.*?)?)'>(?P<title>.*?)<\/a>/Ui";
		
		$OGGdubQ_pattern = '/<a.*?href="(?P<url>.*?\.ogg(?:\?.*?)?)">(?P<title>.*?)<\/a>/Ui';
		$OGGsingQ_pattern = "/<a.*?href='(?P<url>.*?\.ogg(?:\?.*?)?)'>(?P<title>.*?)<\/a>/Ui";
		
		$WAVdubQ_pattern = "/<a.*?href='(?P<url>.*?\.wav(?:\?.*?)?)'>(?P<title>.*?)<\/a>/Ui";
		$WAVsingQ_pattern = "/<a.*?href='(?P<url>.*?\.wav(?:\?.*?)?)'>(?P<title>.*?)<\/a>/Ui";

		
		preg_match_all($MP3dubQ_pattern, $post->post_content, $MP3dubQ, PREG_SET_ORDER);
		preg_match_all($MP3singQ_pattern, $post->post_content, $MP3singQ, PREG_SET_ORDER);
		
		preg_match_all($OGGdubQ_pattern, $post->post_content, $OGGdubQ, PREG_PATTERN_ORDER);
		preg_match_all($OGGsingQ_pattern, $post->post_content, $OGGsingQ, PREG_PATTERN_ORDER);
		
		preg_match_all($WAVdubQ_pattern, $post->post_content, $WAVdubQ, PREG_PATTERN_ORDER);
		preg_match_all($WAVsingQ_pattern, $post->post_content, $WAVsingQ, PREG_PATTERN_ORDER);
		

		$matched_titles_index = 2;
		$matched_url_index = 1;		

		$audios = array_merge($MP3dubQ, $MP3singQ, 
							  $OGGdubQ, $OGGsingQ, 
							  $WAVdubQ, $WAVsingQ
							);

		$count = 0;
		
		foreach($audios as $key => $audio){
			if($audio){
				$count++;
				$tracks[$count]['title'] = $audio['title'];
				$tracks[$count]['audio_file'] = $audio['url'];
				$tracks[$count]['menu_order'] = $count;
			}
		}
		
		if(!$tracks){
			$tracks[1]['title'] = 'No tracks to be played.';
			$tracks[1]['audio_file'] = plugins_url( 'audio/static.mp3' , __FILE__ );
			$tracks[1]['menu_order'] = 1;
		}
		
	}
	ob_start();
	
	?>
	<?php  ?>
	<div class="se_albumplayer">
		
		<div>
    		<img class="cover" src="<?php echo $cover_img_src; ?>" />
    	</div>

		<div class="playlistWrap">
			<table class="playlist">
				<tbody class="tracks">
					<?php if ($tracks){ ?>
						<?php foreach($tracks as $track){ ?>
							<tr class="track" data-track_order="<?php echo $track['menu_order']; ?>" data-track_src="<?php echo $track['audio_file']; ?>">
								<td class="track_order slot3"><?php echo $track['menu_order']; ?></td>
								<td class="track_title"><?php echo $track['title']; ?></td>
								<?php if($downloadable){ ?>
									<td class="slot2 downloadBtn"><div class="downloadBtn icon-download-alt bttn"></div></td>
								<?php } ?>
							</tr>
						<?php } ?>
					<?php } ?>
				</tbody>
			</table>
		</div>
    	
    	<div>
    		<audio preload="none" id="se_albumplayer_audio-<?php echo $album_post_id; ?>"></audio>
    	</div>
		
		

    	<div class="controls" id="controls-<?php echo $album_post_id; ?>">
    		

    		
    		<table class="controlRack" width="100%">
    		
    			
    		
    			<tr>
    				<td class="slot2 playPause"><div class="playPauseBtn icon-play bttn"></div></td>
    				
    				
    				<td class="bars">
    					<div class="progress progress-info">
		    				<div class="bar seekBar"></div>
		    				<div class="bar playBar"></div>
		    				<div class="bar loadBar"></div>
						</div>
    				</td>
    				
    				<td class="slot4 time"><div class="timeCode"></div></td>
    				
    				<td class="slot2 playlistBtn"><div class="playlistBtn icon-list bttn"></div></td>
    				
    				
    				<td class="slot1 volume">
    					<div class="volumeBtn icon-volume-up bttn"></div>
    					<div class="progress vertical bottom volume">
    						<div class="bar volumeBar bar-warning"></div>
    					</div>
    				</td>
    				
    			</tr>
    			
    			
    			
    		</table>
    		
    		
    		    		
    		<table class="info">
    			<tr>
    				<td class="slot2 seekBtn"><div class="seekBtn icon-fast-backward bttn"></div></td>
					<td class="info" ><span class="marquee trackInfo"><?php echo $album_title; ?></span></td>
					<td class="slot2 seekBtn"><div class="seekBtn icon-fast-forward bttn"></div></td>
    			</tr>
    		</table>
	    	    	
    	</div>
    	
    </div>
	
	<?php
	$content = ob_get_clean();
	
	$output = str_replace(array("\r\n", "\r"), "\n", $content);
	$lines = explode("\n", $output);
	$new_lines = array();
	
	foreach ($lines as $i => $line) {
	    if(!empty($line))
	        $new_lines[] = trim($line);
	}
	$output = implode($new_lines);
	
	return $output;
}


/* ========================================== */
/* shortcode */
/* ========================================== */

function SE_AP_shortcode_func( $atts, $content="" ) {
	
	extract( shortcode_atts( array(
      'album_id' => '',
      'dl' => '',
      'cover' => ''
      // ...etc
      ), $atts ) );
	
	
    return SE_AP_print_player($album_id, $dl, $cover);
    //return $content;
     
}
add_shortcode( 'SE_album_player', 'SE_AP_shortcode_func' );


/* --------------------------------------------------------- */



/* ========================================== */
/* strip out audio urls if autoplayer */
/* ========================================== */
add_filter( 'the_content', 'SE_AP_remove_audio_tags' );
function SE_AP_remove_audio_tags( $content ) {
    
    if( strpos($content, '[SE_album_player album_id=autoplayer]') == true ){
    	$autoplayer = true;
    	
		$MP3dubQ_pattern = '/<a.*?href="(?P<url>.*?\.mp3(?:\?.*?)?)">(?P<title>.*?)<\/a>/Ui';
		$MP3singQ_pattern = "/<a.*?href='(?P<url>.*?\.mp3(?:\?.*?)?)'>(?P<title>.*?)<\/a>/Ui";
		
		$OGGdubQ_pattern = '/<a.*?href="(?P<url>.*?\.ogg(?:\?.*?)?)">(?P<title>.*?)<\/a>/Ui';
		$OGGsingQ_pattern = "/<a.*?href='(?P<url>.*?\.ogg(?:\?.*?)?)'>(?P<title>.*?)<\/a>/Ui";
		
		$WAVdubQ_pattern = "/<a.*?href='(?P<url>.*?\.wav(?:\?.*?)?)'>(?P<title>.*?)<\/a>/Ui";
		$WAVsingQ_pattern = "/<a.*?href='(?P<url>.*?\.wav(?:\?.*?)?)'>(?P<title>.*?)<\/a>/Ui";
		
		$clean_content = preg_replace($MP3dubQ_pattern, '', $content);
		$clean_content = preg_replace($MP3singQ_pattern, '', $clean_content);
		
		$clean_content = preg_replace($OGGdubQ_pattern, '', $clean_content);
		$clean_content = preg_replace($OGGsingQ_pattern, '', $clean_content);
		
		$clean_content = preg_replace($WAVdubQ_pattern, '', $clean_content);
		$clean_content = preg_replace($WAVsingQ_pattern, '', $clean_content);
	    	
	    return $clean_content;	
	    
    } else {
    	return $content;
    }
    
}


/* ========================================== */
/* get album tracks */
/* ========================================== */

function SE_AP_get_album_tracks($album_id){
	
	$args = array(
		'post_type' => 'attachment',
		'post_mime_type' => 'audio/mpeg',
		'numberposts' => -1,
		'post_status' => null,
		'post_parent' => $album_id, // any parent
		'orderby' => 'menu_order',
		'order' => 'ASC'
	);
	
	$track_posts = get_posts($args);
	
	foreach($track_posts as $key => $track){
		
		$tracks[$key]['title'] = $track->post_title;
		$tracks[$key]['audio_file'] = $track->guid;
		$tracks[$key]['menu_order'] = $track->menu_order;
	
	}	
	
	return $tracks;
	
}


/* ========================================== */
/* get album cover */
/* ========================================== */

function SE_AP_get_album_cover($album_post_id){
	
	if(has_post_thumbnail($album_post_id)){
		$cover_img_id = get_post_thumbnail_id($album_post_id);
		$cover_img = wp_get_attachment_image_src($cover_img_id, 'large');
		$cover_img_src = $cover_img[0];
	
		return $cover_img_src;
	} else {
	
		return plugins_url( 'img/no_cover.jpg' , __FILE__ );
	
	}
	
	
}

?>