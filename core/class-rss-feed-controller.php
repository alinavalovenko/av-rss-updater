<?php
if ( ! class_exists( 'AV_RSS_Feed_Controller' ) ) {
	class AV_RSS_Feed_Controller {

		public function __construct() {
			$this->av_rss_add_hooks();
		}

		function av_rss_add_thumbnail() {
			global $post;

			$output = '';
			if ( has_post_thumbnail( $post->ID ) ) {
				$thumbnail_ID = get_post_thumbnail_id( $post->ID );
				$thumbnail = wp_get_attachment_image_src( $thumbnail_ID, 'thumbnail' );

				$output .= '<media:thumbnail xmlns:media="http://search.yahoo.com/mrss/" medium="image" type="image/jpeg"';
				$output .= ' url="'. $thumbnail[0] .'"';
				$output .= ' width="'. $thumbnail[1] .'"';
				$output .= ' height="'. $thumbnail[2] .'"';
				$output .= ' />';
			}
			echo $output;
		}


		function av_rss_add_image_gallery() {
			global $post;
			$media  = get_attached_media( 'image', $post->ID );
			if(!empty($media)) {
				$output = '';
				if ( has_post_thumbnail( $post->ID ) ) {
					$thumbnail_ID = get_post_thumbnail_id( $post->ID );
					foreach ( $media as $thumbnail_ID => $attachment ) {
						$thumbnail = wp_get_attachment_image_src( $thumbnail_ID, 'full' );
						$output .= '<media:content xmlns:media="http://search.yahoo.com/mrss/" medium="image" type="image/jpeg"';
						$output .= ' url="' . $thumbnail[0] . '"';
						$output .= ' width="' . $thumbnail[1] . '"';
						$output .= ' height="' . $thumbnail[2] . '"';
						$output .= ' />';
					}
				}
				echo $output;
			}
		}

		public function av_rss_add_hooks() {
			$options = get_option(AV_RSS_OPTION);
			if($options['av_rss_feed_include_thumbnail'] == 'checked') {
				add_action( 'rss2_item', array( $this, 'av_rss_add_thumbnail' ) );
			}
			if($options['av_rss_feed_include_images'] == 'checked') {
				add_action( 'rss2_item', array( $this, 'av_rss_add_image_gallery' ) );
			}
		}

		public function av_rss_run_hooks() {
			do_action( 'do_feed_rdf',  'do_feed_rdf', 1 );
			do_action( 'do_feed_rss',  'do_feed_rss', 1 );
			do_action( 'do_feed_rss2', 'do_feed_rss2', 1 );
			do_action( 'do_feed_atom', 'do_feed_atom', 1 );
		}

	}
}