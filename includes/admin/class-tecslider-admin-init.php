<?php
/**
 * Admin class for EventGlide Pro
 *
 * @package tecslider
 * @author mywptrek
 */
class Tecslider_Admin_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'tecslider_admin_menu_init' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'teclider_enqueue_menu_page_scripts' ) );

		add_action( 'admin_init', array( $this, 'tecslider_register_settings' ) );
	}
	/**
	 * Register tecslider Settings
	 */
	public function tecslider_register_settings() {
		register_setting( 'mwt-tecslider-settings-general-group', 'tecslider_general_settings' );
	}
	/**
	 * Enqueue scripts for menu page.
	 *
	 * @param string $hook Hook Suffix.
	 */
	public function teclider_enqueue_menu_page_scripts( $hook ) {
		global $tecslider;
		if ( 'toplevel_page_tecslider' === $hook ) {
			global $tecslider;
			wp_enqueue_script(
				'tecslider-slick-script',
				$tecslider->plugin_url . '/assets/slick/slick.min.js',
				array( 'jquery' ),
				$tecslider->version,
				true
			);
			wp_enqueue_script(
				'tecslider-admin-page',
				$tecslider->plugin_url . '/assets/admin/tecslider-admin-page.js',
				array( 'jquery', 'tecslider-slick-script' ),
				$tecslider->version,
				true
			);
			wp_enqueue_style(
				'tecslider-admin-page',
				$tecslider->plugin_url . '/assets/admin/tecslider-admin-page.css',
				array(),
				$tecslider->version
			);
		}
		wp_enqueue_style( 'tecslider-boxicons-style', $tecslider->tecslider_assets . 'boxicons/css/boxicons.min.css', array(), $tecslider->version );
		wp_enqueue_style( 'tecslider-settings-style', $tecslider->tecslider_assets . 'css/tecslider-settings-style.css', array(), $tecslider->version );
		wp_enqueue_script( 'tecslider-settings-script', $tecslider->tecslider_assets . 'js/tecslider-settings-script.js', array( 'jquery' ), $tecslider->version, true );
		$params = array(
			'ajaxurl'    => admin_url( 'admin-ajax.php' ),
			'ajax_nonce' => wp_create_nonce( 'tecslider_settings_ajax_nonce' ),
			'dark_mode'  => esc_html__( 'Dark Mode', 'tecslider' ),
			'light_mode' => esc_html__( 'Light Mode', 'tecslider' ),
		);
		wp_localize_script( 'tecslider-settings-script', 'tecslider_settings', $params );
	}
	/**
	 * Init Slider admin menu.
	 */
	public function tecslider_admin_menu_init() {
		add_menu_page(
			esc_html__( 'EventGlide', 'tecslider' ),
			esc_html__( 'EventGlide', 'tecslider' ),
			'manage_options',
			'tecslider',
			array( $this, 'tecslider_admin_menu_page' ),
			// Encode the SVG content before embedding it in an HTML document.
			// phpcs:ignore
			'data:image/svg+xml;base64,' . base64_encode( '<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 32 32">
			<!-- Background Circle -->
			<circle cx="17" cy="17" r="15" stroke="transparent" stroke-width="2" />
			<!-- Letter "E" -->
			<text x="5" y="23" font-family="Arial" font-size="18" font-weight="bold" fill="transparent">E</text>
			<!-- Letter "G" -->
			<text x="15" y="23" font-family="Arial" font-size="18" font-weight="bold" fill="transparent">G</text>
			<circle cx="12" cy="26" r="1" fill="transparent" />
			<circle cx="17" cy="26" r="1" fill="transparent" />
			<circle cx="22" cy="26" r="1" fill="transparent" />
			</svg>'
			),
			6
		);
	}
	/**
	 * Adds Slider admin page
	 */
	public function tecslider_admin_menu_page() {
		wp_enqueue_style( 'tecslider-boxicons-style' );
		wp_enqueue_style( 'tecslider-settings-style' );
		wp_enqueue_script( 'tecslider-settings-script' );

		require_once 'pages/page-tecslider-admin-settings.php';
	}
}
