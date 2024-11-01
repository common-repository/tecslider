<?php
/**
 * EventGlide Pro Admin AJAX
 *
 * @since 1.0.0
 * @author mywprtrek
 * @package tecslider
 */
class Tecslider_Settings_AJAX {
	/**
	 * Prepend String
	 *
	 * @var string
	 */
	private $prepend = 'tecslider_';
	/**
	 * Constructor
	 */
	public function __construct() {
		$ajax_events = array(
			'set_dark_light_mode' => 'set_dark_light_mode',
		);
		foreach ( $ajax_events as $ajax_event => $class ) {
			add_action( 'wp_ajax_' . $this->prepend . $ajax_event, array( $this, $this->prepend . $class ) );
			add_action( 'wp_ajax_nopriv_' . $this->prepend . $ajax_event, array( $this, $this->prepend . $class ) );
		}
	}
	/**
	 * Set Dark Mode or Light Mode
	 */
	public function tecslider_set_dark_light_mode() {
		global $tecslider;
		$type  = 'general';
		$field = 'mode';
		$res   = check_ajax_referer( 'tecslider_settings_ajax_nonce', 'tecslider_nonce' );
		if ( isset( $_POST['action'] ) && 'tecslider_set_dark_light_mode' !== $_POST['action'] ) {
			return;
		}
		$mode   = isset( $_POST['mode'] ) ? sanitize_text_field( wp_unslash( $_POST['mode'] ) ) : 'light';
		$return = $tecslider->function->tecslider_set_settings( $type, $field, $mode );
		if ( $return ) {
			echo wp_json_encode(
				array(
					'status' => 'good',
					'msg'    => esc_html__( 'Settings Updated.', 'tecslider' ),
				)
			);
			exit;
		} else {
			echo wp_json_encode(
				array(
					'status' => 'bad',
					'msg'    => esc_html__( 'Settings Updation failed.', 'tecslider' ),
				)
			);
			exit;
		}
	}
}
new Tecslider_Settings_AJAX();
