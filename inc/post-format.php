<?php

/*-----------------------------------------------------------------------------------*/
/* Embed audio player for mp3 content
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'wallpress_audio_player' ) ) :
function wallpress_audio_player( $post_id ) {
	$attachments = get_children( array( 'post_parent' => $post_id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'audio' ) );
	if ( $attachments ) {
		$audio =  array_shift( $attachments );
?>
	<div id="jquery_jplayer_<?php echo $audio->ID ?>" class="jp-jplayer" data-interface="jp_container_<?php echo $audio->ID ?>" data-file="<?php echo wp_get_attachment_url( $audio->ID ); ?>" data-swf="<?php echo get_template_directory_uri(); ?>/assets/swf/"></div>

	<div id="jp_container_<?php echo $audio->ID ?>" class="jp-audio">
		<div class="jp-type-single">
			<div class="jp-gui jp-interface">
				<ul class="jp-controls">
					<li><a href="javascript:;" class="jp-play" tabindex="1"><i class="fa fa-play"></i></a></li>
					<li><a href="javascript:;" class="jp-pause" tabindex="1"><i class="fa fa-pause"></i></a></li>
					<li><a href="javascript:;" class="jp-stop" tabindex="1"><i class="fa fa-stop"></i></a></li>
				</ul>

				<!-- you can comment out any of the following <div>s too -->

				<div class="jp-progress">
					<div class="jp-progress-inner">
						<div class="jp-seek-bar">
							<div class="jp-play-bar"></div>
						</div>
					</div>
				</div>

				<div class="jp-volume-bar-wrap">
					<ul class="jp-controls-volume">
						<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute"><i class="fa fa-volume-off"></i></a></li>
						<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute"><i class="fa fa-volume-up"></i></a></li>
					</ul>
					<div class="jp-volume-bar">
						<div class="jp-volume-bar-value"></div>
					</div>
				</div>

				<div class="jp-current-time"></div>
				<div class="jp-duration"></div>

			</div>
		</div>
	</div>
	<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#jquery_jplayer_<?php echo $audio->ID ?>").jPlayer({
		ready: function(event) {
				$(this).jPlayer("setMedia", {
					mp3: "<?php echo wp_get_attachment_url( $audio->ID ); ?>",
				});
			},
			swfPath: "<?php echo get_template_directory_uri(); ?>/assets/swf/",
			cssSelectorAncestor: '#jp_container_<?php echo $audio->ID ?>',
			supplied: "mp3, all"
		});
	});
	</script>
	<?php
	}
}
endif;

/*-----------------------------------------------------------------------------------*/
/* Post format gallery
/*-----------------------------------------------------------------------------------*/
if ( !function_exists( 'wallpress_gallery' ) ) :
function wallpress_gallery(  ) {
	global $post;
	$output = '';
	$images = get_posts( array(
		'numberposts'		=>	-1,
		'post_mime_type'	=>	'image',
		'orderby'			=>	'menu_order',
		'order'				=>	'ASC',
		'post_type'			=>	'attachment',
		'post_parent'		=>	$post->ID,
		'post_status'		=> 	'inherit'
		)
	);
	if( count($images) > 0 ){
		$output .=  '<div class="dw-gallery-container" ><div class="mask"><div id="gallery-'.$post->ID.'" class="dw-gallery">';
		foreach ($images as $image) {
			$output .=  '<div class="dw-gallery-item"><a href="'.get_permalink($post->ID).'" title="'.get_the_title($post->ID).'">';

			$grid = get_post_meta($post->ID, 'grid', true);

			$size = 'double' == $grid ? 'medium' : 'thumbnail';
			if( is_single() || is_page_template('layout-blog.php') ){
				$size = 'medium';
			}

			$output .=  wp_get_attachment_image($image->ID, $size, array( 's'));
			$output .=  '</a></div>';
		}
		$output .=  '</div></div>';
		$output .=  '<ul class="dw-gallery-pagination"></ul>';
		$output .=  '<a href="#" class="dw-gallery-next"><i class="fa fa-chevron-circle-right"></i></a><a href="#" class="dw-gallery-prev"><i class="fa fa-chevron-circle-left"></i></a></div>';
	}
	return $output;
}
endif;
