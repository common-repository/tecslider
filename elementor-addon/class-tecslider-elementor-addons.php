<?php
/**
 * Elementor addons for Event Slider
 *
 * @since 3.0.0
 * @author mywptrek
 */

class Tecslider_Elementor_Addons {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'elementor/widgets/register', array( $this, 'register_tecslider_widget' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'register_elementor_edit_scripts' ) );

		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'register_elementor_edit_styles' ) );

		add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'register_elementor_frontend_scripts' ) );
		add_action( 'elementor/frontend/after_enqueue_styles', array( $this, 'register_elementor_frontend_styles' ) );
	}
	/**
	 * Register Elementor frontend scripts
	 */
	public function register_elementor_frontend_scripts() {
		global $tecslider;
		wp_register_script( 'tecslider-script', $tecslider->plugin_url . '/assets/slick/slick.min.js', array( 'jquery' ), $tecslider->version, true );
	}
	/**
	 * Register Elementor frontend styles
	 */
	public function register_elementor_frontend_styles() {
		global $tecslider;
		wp_register_style( 'tecslider-styles', $tecslider->plugin_url . '/assets/slick/slick.css', array(), $tecslider->version );
		wp_register_style( 'tecslider-tmeme-styles', $tecslider->plugin_url . '/assets/slick/slick-theme.css', array(), $tecslider->version );
		wp_register_style( 'tecslider-block-styles', $tecslider->plugin_url . '/includes/blocks/build/style-index.css', array(), $tecslider->version );
	}
	/**
	 * Register oEmbed Widget.
	 *
	 * Include widget file and register widget class.
	 *
	 * @since 1.0.0
	 * @param \Elementor\Widgets_Manager $widgets_manager Elementor widgets manager.
	 * @return void
	 */
	public function register_tecslider_widget( $widgets_manager ) {
		require_once __DIR__ . '/widgets/class-tecslider-elementor-widget.php';

		$widgets_manager->register( new \Tecslider_Elementor_Widget() );

	}
	/**
	 * Register Elementor edit scripts
	 */
	public function register_elementor_edit_scripts() {
		global $tecslider;
		wp_enqueue_script(
			'tecslider-elementor-edit',
			plugin_dir_url( __FILE__ ) . 'assets/js/elementor-edit.js',
			array( 'jquery' ),
			$tecslider->version,
			true
		);
	}
	/**
	 * Register Elementor edit styles
	 */
	public function register_elementor_edit_styles() {
		global $tecslider;
		wp_enqueue_style(
			'tecslider-elementor-edit',
			plugin_dir_url( __FILE__ ) . 'assets/css/elementor-edit.css',
			array(),
			$tecslider->version
		);
	}
}
new Tecslider_Elementor_Addons();
