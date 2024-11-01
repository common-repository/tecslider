<?php
/**
 * Blocks for EventGlide Pro Init
 *
 * @author  mywptrek
 * @package tecslider
 * @version 1.0.0
 */
class Tecslider_Blocks_Init {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'tecslider_init_gutenberg_blocks' ) );
	}
	/**
	 * Initialize Block
	 */
	public function tecslider_init_gutenberg_blocks() {
		global $tecslider;
		wp_register_script( 'tecslider-script', $tecslider->plugin_url . '/assets/slick/slick.min.js', array( 'jquery' ), $tecslider->version, true );
		wp_register_style( 'tecslider-styles', $tecslider->plugin_url . '/assets/slick/slick.css', array(), $tecslider->version );
		wp_register_style( 'tecslider-theme-styles', $tecslider->plugin_url . '/assets/slick/slick-theme.css', array(), $tecslider->version );
		wp_enqueue_style( 'tecslider-google-fonts', 'https://fonts.googleapis.com/css?family=Roboto|Open+Sans|Lato|Montserrat|Poppins|Nunito|Playfair+Display|Merriweather|Dancing+Script|Pacifico&display=swap', array(), $tecslider->version );
		register_block_type(
			__DIR__,
			array(
				'api_version'     => 2,
				'attributes'      => array(
					'plugin'               => array(
						'type'    => 'string',
						'default' => 'tec',
					),
					'sliderTheme'          => array(
						'type'    => 'string',
						'default' => 'datetop',
					),
					'sliderType'           => array(
						'type'    => 'string',
						'default' => 'upcoming',
					),
					'eventInRow'           => array(
						'type'    => 'number',
						'default' => 3,
					),
					'eventInSlide'         => array(
						'type'    => 'number',
						'default' => 3,
					),
					'autoplay'             => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'transitionDelay'      => array(
						'type'    => 'number',
						'default' => 200,
					),
					'colorScheme'          => array(
						'type'    => 'string',
						'default' => '#5a30f3',
					),
					'blockId'              => array(
						'type' => 'string',
					),
					'customSelectedEvents' => array(
						'type'    => 'string',
						'default' => null,
					),
					'newtab'               => array(
						'type'    => 'boolean',
						'default' => true,
					),
					'category'             => array(
						'type'    => 'string',
						'default' => '',
					),
					'titleFontFace'        => array(
						'type'    => 'string',
						'default' => '',
					),
					'titleFontSize'        => array(
						'type'    => 'number',
						'default' => 20,
					),
					'descFontFace'         => array(
						'type'    => 'string',
						'default' => '',
					),
					'descFontSize'         => array(
						'type'    => 'number',
						'default' => 14,
					),
					'datetimeFontFace'     => array(
						'type'    => 'string',
						'default' => '',
					),
					'datetimeFontSize'     => array(
						'type'    => 'number',
						'default' => 0,
					),
					'countdownTimer'       => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'dots'                 => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'darkmode'             => array(
						'type'    => 'boolean',
						'default' => false,
					),
					'slideHeight'          => array(
						'type'    => 'number',
						'default' => 300,
					),
					'imageHeight'          => array(
						'type'    => 'number',
						'default' => 200,
					),
				),
				'render_callback' => array( $tecslider->blocks, 'render_block_core_archives_tecsb' ),
				'script'          => 'tecslider-script',
			)
		);
		wp_enqueue_script(
			'tec-slider-block-editor',
			plugins_url( 'tec-slider-editor.js', __FILE__ ),
			array( 'jquery' ),
			'1.0',
			true
		);
		wp_enqueue_style(
			'roboto-google-font',
			'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap',
			array(),
			$tecslider->version
		);
		wp_enqueue_style(
			'tecslider-slick-style',
			$tecslider->plugin_url . '/assets/slick/slick.css',
			array(),
			$tecslider->version
		);
		wp_enqueue_style(
			'tecslider-slick-theme',
			$tecslider->plugin_url . '/assets/slick/slick-theme.css',
			array(),
			$tecslider->version
		);
		wp_enqueue_style(
			'tecslider-box-icons',
			$tecslider->plugin_url . '/assets/boxicons/css/boxicons.min.css',
			array(),
			$tecslider->version
		);
		$categories[] = array(
			'name' => '',
			'slug' => '',
		);
		$terms        = get_terms( array( 'taxonomy' => Tribe__Events__Main::TAXONOMY ) );
		if ( empty( $terms ) || is_wp_error( $terms ) ) {
			$categories = array();
		} else {
			foreach ( $terms as $single_term ) {
				$name = $single_term->name;
				$slug = $single_term->slug;

				$categories[] = array(
					'slug' => $slug,
					'name' => $name,
				);
			}
		}

		$plugins        = array(
			'tec',
			'eventon',
		);
		$active_plugins = array();
		foreach ( $plugins as $plugin ) {
			switch ( $plugin ) {
				case 'tec':
					if ( class_exists( 'Tribe__Events__Main' ) ) {
						$active_plugins[] = array(
							'name' => esc_html__( 'The Events Calendar', 'tecslider' ),
							'slug' => 'tec',
						);
					}
					break;
				case 'eventon':
					if ( class_exists( 'EventON' ) ) {
						$active_plugins[] = array(
							'name' => esc_html__( 'Eventon', 'tecslider' ),
							'slug' => 'eventon',
						);
					}
					break;
			}
		}
		$rest_api_url = get_rest_url();

		wp_add_inline_script(
			'tec-slider-block-editor',
			'var eventCategoriesData = ' . wp_json_encode( $categories ) . ';',
			'before'
		);
		wp_add_inline_script(
			'tec-slider-block-editor',
			'var tecsliderActivePlugins = ' . wp_json_encode( $active_plugins ) . ';',
			'before'
		);
		$is_premium = tsa_fs()->is_premium() ? 'true' : 'false';
		wp_add_inline_script(
			'tec-slider-block-editor',
			'var tecsliderIsPremium = ' . $is_premium . ';',
			'before'
		);
		$general             = get_option( 'tecslider_general_settings' );
		$remove_cd_zero_days = $tecslider->function->tecslider_return_option_yesno( $general, 'remove_cd_zero_days' );
		$remove_cd_hours     = $tecslider->function->tecslider_return_option_yesno( $general, 'remove_cd_hours' );
		$remove_cd_minutes   = $tecslider->function->tecslider_return_option_yesno( $general, 'remove_cd_minutes' );
		$remove_cd_seconds   = $tecslider->function->tecslider_return_option_yesno( $general, 'remove_cd_seconds' );
		$event_starts_in     = isset( $general['event_starts_in'] ) && ! empty( $general['event_starts_in'] ) ? $general['event_starts_in'] : esc_html__( 'Event starts in ...', 'tecslider' );
		$event_ends_in       = isset( $general['event_ends_in'] ) && ! empty( $general['event_ends_in'] ) ? $general['event_ends_in'] : esc_html__( 'Event ends in ...', 'tecslider' );
		$event_has_ended     = isset( $general['event_has_ended'] ) && ! empty( $general['event_has_ended'] ) ? $general['event_has_ended'] : esc_html__( 'Event has ended', 'tecslider' );
		wp_localize_script(
			'tecslider-script',
			'momocountdown',
			array(
				'end'    => $event_has_ended,
				'start'  => $event_starts_in,
				'endsin' => $event_ends_in,
				'dhmsd'  => esc_html__( 'day', 'tecslider' ),
				'dhmsh'  => esc_html__( 'hr', 'tecslider' ),
				'dhmsm'  => esc_html__( 'min', 'tecslider' ),
				'dhmss'  => esc_html__( 'sec', 'tecslider' ),
				'rmsec'  => $remove_cd_seconds,
				'rmmin'  => $remove_cd_minutes,
				'rmhrs'  => $remove_cd_hours,
				'rmday'  => $remove_cd_zero_days,
				'tmz'    => Tribe__Timezones::wp_timezone_string(),
			)
		);
	}
}
new Tecslider_Blocks_Init();
