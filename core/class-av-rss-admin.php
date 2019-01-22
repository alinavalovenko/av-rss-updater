<?php
if(!class_exists('AV_RSS_Feed_Admin')){
	class AV_RSS_Feed_Admin{
		public function __construct() {
			add_action('wp_enqueue_scripts', array( $this,'av_rss_enqueue_scripts'));
		}

		function av_rss_enqueue_scripts(){
			wp_register_script( AV_RSS_SLUG . '-scripts', AV_RSS_ASSETS . 'js/scripts.js' );
			wp_register_style( AV_RSS_SLUG . '-styles', AV_RSS_ASSETS . 'css/styles.css' );

			wp_enqueue_style(AV_RSS_SLUG . '-styles');
			wp_enqueue_script(AV_RSS_SLUG . '-scripts');
		}
	}
}