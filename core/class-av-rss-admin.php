<?php
if(!class_exists('AV_RSS_Feed_Admin')){
	require_once (AV_RSS_CORE . 'class-rss-feed-controller.php');
	class AV_RSS_Feed_Admin{
		private $options;
		public function __construct() {
			add_action('wp_enqueue_scripts', array( $this,'av_rss_enqueue_scripts'));
			add_action( 'admin_menu', array( $this, 'av_rss_add_admin_page' ) );
			add_action( 'admin_init', array( $this, 'av_rss_page_init' ) );
			add_filter('wp_feed_cache_transient_lifetime', array('av_rss_force_update'));
			add_action( 'wp_ajax_av_rss_save_options', array( $this, 'av_rss_save_options' ) );


		}

		function av_rss_enqueue_scripts(){
			wp_register_script( AV_RSS_SLUG . '-scripts', AV_RSS_ASSETS . 'js/scripts.js' , array( 'jquery' ), '0.1', true );
			wp_register_style( AV_RSS_SLUG . '-styles', AV_RSS_ASSETS . 'css/styles.css' );

			wp_enqueue_style(AV_RSS_SLUG . '-styles');
			wp_enqueue_script(AV_RSS_SLUG . '-scripts');
		}

		function  av_rss_add_admin_page(){
			add_submenu_page('tools.php', 'AV RSS Feed Updater', 'RSS Feed Updater', 'manage_options', AV_RSS_SLUG, array($this,'av_rss_create_admin_page'));
		}

		function av_rss_page_init(){
			register_setting(
				AV_RSS_SLUG . '_option_group',
				AV_RSS_SLUG . '_option',
				array( $this, 'av_rss_fields_sanitize' )
			);
			add_settings_section(
				AV_RSS_SLUG . '_option',
				'AV RSS Updater',
				array( $this, 'av_rss_print_section_info' ),
				AV_RSS_SLUG
			);

			add_settings_field(
				'av_rss_feed_update_period',
				'Update frequency (minutes)',
				array( $this, 'av_rss_feed_update_period' ),
				AV_RSS_SLUG,
				AV_RSS_SLUG . '_option'
			);
			add_settings_field(
				'av_rss_feed_include_thumbnail',
				'Include thumbnail',
				array( $this, 'av_rss_feed_include_thumbnail' ),
				AV_RSS_SLUG,
				AV_RSS_SLUG . '_option'
			);
			add_settings_field(
				'av_rss_feed_include_images',
				'Include attachment images',
				array( $this, 'av_rss_feed_include_images' ),
				AV_RSS_SLUG,
				AV_RSS_SLUG . '_option'
			);
		}

		function  av_rss_create_admin_page(){
			$this->av_rss_enqueue_scripts();
			$this->options = get_option( AV_RSS_SLUG . '_option' );
			require_once (AV_RSS_VIEW . 'dashboard.php');
		}

		function av_rss_save_options(){
			$data['av_rss_feed_update_period'] =  $_POST['data'];
			$data['av_rss_feed_include_thumbnail'] =  $_POST['data'];
			$data['av_rss_feed_include_images'] =  $_POST['data'];
			wp_die();
		}

		function av_rss_force_update(){
			$feed = new AV_RSS_Feed_Controller();
			$period = get_option('av_rss_feed_period'); //
			return !empty($period60) ? $period : 60;
		}

		function av_rss_fields_sanitize(){}

		public function av_rss_print_section_info() {
			echo '';
		}

		public function av_rss_feed_update_period(){
			printf(
				'<input type="number"  min="30" max="1140" step = "30" name="' . AV_RSS_SLUG . '_option[av_rss_feed_update_period]" value="%s"/>',
				isset( $this->options['av_rss_feed_update_period'] ) ? esc_attr( $this->options['av_rss_feed_update_period'] ) : 30
			);
		}

		public function av_rss_feed_include_thumbnail(){
			printf(
				'<input type="checkbox"  name="' . AV_RSS_SLUG . '_option[av_rss_feed_include_thumbnail]" %s/>',
				isset( $this->options['av_rss_feed_include_thumbnail'] ) ? esc_attr( $this->options['av_rss_feed_include_thumbnail'] ) : 'checked'
			);
		}

		public function av_rss_feed_include_images(){
			printf(
				'<input type="checkbox"  name="' . AV_RSS_SLUG . '_option[av_rss_feed_include_images]" %s/>',
				isset( $this->options['av_rss_feed_include_images'] ) ? esc_attr( $this->options['av_rss_feed_include_images'] ) : 'checked'
			);
		}
	}
}