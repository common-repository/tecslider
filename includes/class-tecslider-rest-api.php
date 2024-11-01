<?php
/**
 * Rest API Class for Slider Addons
 *
 * @author   mywptrek
 * @version  1.0.0
 * @package  tecslider
 */
class Tecslider_Rest_API {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'tecslider_initiate_rest_api' ) );
	}

	/**
	 * Register Rest Route
	 */
	public function tecslider_initiate_rest_api() {
		$version   = '1';
		$namespace = 'tecslider/v' . $version;
		$base      = 'events';
		register_rest_route(
			$namespace,
			$base,
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'tecslider_generate_events_sliders' ),
				'permission_callback' => function () {
					return ( '__return_true' );
				},
			)
		);
	}
	/**
	 * Generate Sliders Templates
	 *
	 * @param WP_Rest_Request $request Request.
	 */
	public function tecslider_generate_events_sliders( $request ) {
		global $tecslider;
		$attributes       = $request->get_params();
		$no_of_events     = 5;
		$theme_selected   = isset( $attributes['sliderTheme'] ) ? $attributes['sliderTheme'] : 'datetop';
		$slider_type      = isset( $attributes['sliderType'] ) ? $attributes['sliderType'] : 'upcoming';
		$event_in_row     = isset( $attributes['eventInRow'] ) ? $attributes['eventInRow'] : 3;
		$event_in_slide   = isset( $attributes['eventInSlide'] ) ? $attributes['eventInSlide'] : 3;
		$auto_play        = isset( $attributes['autoPlay'] ) ? $attributes['autoPlay'] : true;
		$transition_delay = isset( $attributes['transitionDelay'] ) ? $attributes['transitionDelay'] : 200;
		$color_scheme     = isset( $attributes['colorScheme'] ) ? $attributes['colorScheme'] : '#5a30f3';
		$slider_id        = isset( $attributes['blockId'] ) ? $attributes['blockId'] : false;
		$title_font       = isset( $attributes['titleFontFace'] ) ? $attributes['titleFontFace'] : '';
		$title_size       = isset( $attributes['titleFontSize'] ) ? $attributes['titleFontSize'] : '20';
		$desc_font        = isset( $attributes['descFontFace'] ) ? $attributes['descFontFace'] : '';
		$desc_size        = isset( $attributes['descFontSize'] ) ? $attributes['descFontSize'] : '14';
		$dt_font          = isset( $attributes['datetimeFontFace'] ) ? $attributes['datetimeFontFace'] : '';
		$dt_size          = isset( $attributes['datetimeFontSize'] ) ? $attributes['datetimeFontSize'] : 0;
		$countdown_timer  = isset( $attributes['countdownTimer'] ) ? $attributes['countdownTimer'] : false;
		$newtab           = isset( $attributes['newtab'] ) ? $attributes['newtab'] : true;
		$dots             = isset( $attributes['dots'] ) ? $attributes['dots'] : true;
		$darkmode         = isset( $attributes['darkmode'] ) ? $attributes['darkmode'] : true;
		$slideheight      = isset( $attributes['slideHeight'] ) ? $attributes['slideHeight'] : 300;
		$imageheight      = isset( $attributes['imageHeight'] ) ? $attributes['imageHeight'] : 200;
		$category         = isset( $attributes['category'] ) ? $attributes['category'] : '';
		$slideheight      = isset( $attributes['slideHeight'] ) ? $attributes['slideHeight'] : 300;
		$imageheight      = isset( $attributes['imageHeight'] ) ? $attributes['imageHeight'] : 200;
		$ticket_info      = isset( $attributes['ticketInfo'] ) ? $attributes['ticketInfo'] : false;
		$args             = array(
			'theme'            => $theme_selected,
			'pastpresent'      => $slider_type,
			'eirow'            => $event_in_row,
			'sirow'            => $event_in_slide,
			'auto'             => $auto_play,
			'transition'       => $transition_delay,
			'noe'              => $no_of_events,
			'color'            => $color_scheme,
			'theme'            => $theme_selected,
			'slider_id'        => $slider_id,
			'titleFontFace'    => $title_font,
			'titleFontSize'    => $title_size,
			'descFontFace'     => $desc_font,
			'descFontSize'     => $desc_size,
			'datetimeFontFace' => $dt_font,
			'datetimeFontSize' => $dt_size,
			'countdown_timer'  => $countdown_timer,
			'newtab'           => $newtab,
			'dots'             => $dots,
			'darkmode'         => $darkmode,
			'slideheight'      => $slideheight,
			'imageheight'      => $imageheight,
			'category'         => $category,
			'ticketInfo'       => $ticket_info,
		);
		$events           = $tecslider->function->tecslider_generate_tec_events( $args );
		return wp_json_encode(
			array(
				'status'  => 'good',
				'content' => $events,
			)
		);
	}
}
new Tecslider_Rest_API();
