<?php
/**
 * Plugin Name: Jcreation Site Setup Loader
 * Description: Auto-loads the Jcreation site setup once so the starter website is created without manual plugin activation.
 * Version: 1.0.0
 * Author: Codihaus
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$jcreation_setup_plugin = WP_CONTENT_DIR . '/plugins/jcreation-site-setup/jcreation-site-setup.php';

if ( file_exists( $jcreation_setup_plugin ) && ! class_exists( 'JCreation_Site_Setup', false ) ) {
	require_once $jcreation_setup_plugin;
}

add_action(
	'admin_init',
	function () {
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}

		if ( ! class_exists( 'JCreation_Site_Setup', false ) ) {
			return;
		}

		if ( get_option( 'jcreation_site_setup_version' ) === JCreation_Site_Setup::VERSION ) {
			return;
		}

		JCreation_Site_Setup::run();
	}
);
