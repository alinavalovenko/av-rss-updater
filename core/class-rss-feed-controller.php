<?php
if ( ! class_exists( 'AV_RSS_Feed_Controller' ) ) {
	class AV_RSS_Feed_Controller {
		public function __construct() {
			add_action( 'rss2_item', array( $this, 'av_rss_add_thumbnail' ) );
			add_action( 'rss2_item', array( $this, 'av_rss_add_image_gallery' ) );
			echo 'AV_RSS_Feed_Controller completed';
		}

		function av_rss_add_thumbnail() {
			global $post;
			$output       = '';
			$thumbnail_ID = get_post_thumbnail_id( $post->ID );
			$thumbnail    = wp_get_attachment_image_src( $thumbnail_ID, 'thumbnail' );
			$output       .= '<post-thumbnail>';
			$output       .= '<url>' . $thumbnail[0] . '</url>';
			$output       .= '<width>' . $thumbnail[1] . '</width>';
			$output       .= '<height>' . $thumbnail[2] . '</height>';
			$output       .= '</post-thumbnail>';

			echo $output;
		}


		function av_rss_add_image_gallery() {
			global $post;
			$media = get_attached_media( 'image', $post->ID );
			$output       = '';
			$output       .= '<post-media>';
			foreach ($media as $thumbnail_ID => $attachment ) {
				$thumbnail    = wp_get_attachment_image_src( $thumbnail_ID, 'full' );
				$output       .= '<url>' . $thumbnail[0] . '</url>';
				$output       .= '<width>' . $thumbnail[1] . '</width>';
				$output       .= '<height>' . $thumbnail[2] . '</height>';
			}
			$output       .= '</post-media>';
			echo $output;
		}


	}
}