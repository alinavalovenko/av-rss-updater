<?php
/*
	Plugin Name: RSS Feed Updater
	Description: Update RSS Feeds
	Version: 1.0
	Author: Alina Valovenko
	Author URI: http://www.valovenko.pro
	License: GPL2
*/

if ( ! class_exists( 'AV_RSS_Updater' ) ) {
	define( 'AV_RSS_DIR', plugin_dir_path( __FILE__) );
	define( 'AV_RSS_URL', plugin_dir_url( __FILE__) );
	define( 'AV_RSS_ASSETS', AV_RSS_URL . 'assets/' );
	define( 'AV_RSS_VIEW', AV_RSS_DIR . 'view/' );
	define( 'AV_RSS_CORE', AV_RSS_DIR . 'core/' );
	define( 'AV_RSS_SLUG', 'av-rss-feed-updater' );

	require_once( AV_RSS_CORE . 'class-av-rss-admin.php' );

	class AV_RSS_Updater {

		function __construct() {
			register_activation_hook( plugin_basename( __FILE__ ), array( &$this, 'av_rss_activate' ) );
			register_deactivation_hook( plugin_basename( __FILE__ ), array( &$this, 'av_rss_deactivate' ) );
			register_uninstall_hook( plugin_basename( __FILE__ ), array( &$this, 'av_rss_uninstall' ) );

			$admin = new AV_RSS_Feed_Admin();
		}

		public function av_rss_activate() {
			return true;
		}

		public function av_rss_deactivate() {
			return true;
		}

		public function av_rss_uninstall() {
			return true;
		}
	} new AV_RSS_Updater();
}