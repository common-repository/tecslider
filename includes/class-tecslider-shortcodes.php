<?php
/**
 * Rest API Class for Slider Addons
 *
 * @author   mywptrek
 * @since  1.2.0
 * @package  tecslider
 */
class Tecslider_Shortcodes {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_shortcode( 'add_mwt_tec_slider', array( $this, 'tecslider_block_shortcode' ) );
	}
	/**
	 * Add shortcode to generate blocks
	 *
	 * @param array $attributes Arguments.
	 */
	public function tecslider_block_shortcode( $attributes = array() ) {
		if ( empty( $attributes ) || ! is_array( $attributes ) ) {
			$attributes = array();
		}
		global $tecslider;
		wp_enqueue_script( 'tecslider-script', $tecslider->plugin_url . '/assets/slick/slick.min.js', array( 'jquery' ), $tecslider->version, true );
		wp_enqueue_style( 'tecslider-styles', $tecslider->plugin_url . '/assets/slick/slick.css', array(), $tecslider->version );
		wp_enqueue_style( 'tecslider-tmeme-styles', $tecslider->plugin_url . '/assets/slick/slick-theme.css', array(), $tecslider->version );
		wp_enqueue_style( 'tecslider-block-styles', $tecslider->plugin_url . '/includes/blocks/build/style-index.css', array(), $tecslider->version );
		$no_of_events      = 5;
		$theme_selected    = isset( $attributes['slidertheme'] ) && ! empty( $attributes['slidertheme'] ) ? $attributes['slidertheme'] : 'datetop';
		$slider_type       = isset( $attributes['slidertype'] ) && ! empty( $attributes['slidertype'] ) ? $attributes['slidertype'] : 'upcoming';
		$event_in_row      = isset( $attributes['eventinrow'] ) && ! empty( $attributes['eventinrow'] ) ? $attributes['eventinrow'] : 3;
		$event_in_slide    = isset( $attributes['eventinslide'] ) && ! empty( $attributes['eventinslide'] ) ? $attributes['eventinslide'] : 3;
		$auto_play         = isset( $attributes['autoplay'] ) && ! empty( $attributes['autoplay'] ) ? (bool) $attributes['autoplay'] : true;
		$auto_play         = ( 'true' === $auto_play ) || ( true === $auto_play ) ? true : false;
		$transition_delay  = isset( $attributes['transitiondelay'] ) && ! empty( $attributes['transitiondelay'] ) ? (int) $attributes['transitiondelay'] : 200;
		$color_scheme      = isset( $attributes['colorscheme'] ) && ! empty( $attributes['colorscheme'] ) ? $attributes['colorscheme'] : '#5a30f3';
		$slider_id         = isset( $attributes['blockid'] ) && ! empty( $attributes['blockid'] ) ? (bool) $attributes['blockid'] : false;
		$venue_enabled     = isset( $attributes['venueenabled'] ) && ! empty( $attributes['venueenabled'] ) ? (bool) $attributes['venueenabled'] : false;
		$organizer_enabled = isset( $attributes['organizerenabled'] ) && ! empty( $attributes['organizerenabled'] ) ? $attributes['organizerenabled'] : false;
		$newtab            = isset( $attributes['newtab'] ) ? (bool) $attributes['newtab'] : true;
		$cevents           = isset( $args['cevents'] ) ? $args['cevents'] : '';
		$title_font        = isset( $attributes['titleFontFace'] ) ? $attributes['titleFontFace'] : '';
		$title_size        = isset( $attributes['titleFontSize'] ) ? $attributes['titleFontSize'] : '20';
		$desc_font         = isset( $attributes['descFontFace'] ) ? $attributes['descFontFace'] : '';
		$desc_size         = isset( $attributes['descFontSize'] ) ? $attributes['descFontSize'] : '14';
		$dt_font           = isset( $attributes['datetimeFontFace'] ) ? $attributes['datetimeFontFace'] : '';
		$dt_size           = isset( $attributes['datetimeFontSize'] ) ? $attributes['datetimeFontSize'] : 0;
		$countdown_timer   = isset( $attributes['countdowntimer'] ) ? (bool) $attributes['countdowntimer'] : false;
		$dots              = isset( $attributes['dots'] ) ? (bool) $attributes['dots'] : false;
		$darkmode          = isset( $attributes['darkmode'] ) ? (bool) $attributes['darkmode'] : false;
		$category          = isset( $attributes['category'] ) ? $attributes['category'] : '';
		$slideheight       = isset( $attributes['slideHeight'] ) ? $attributes['slideHeight'] : 300;
		$imageheight       = isset( $attributes['imageHeight'] ) ? $attributes['imageHeight'] : 200;
		$ticket_info       = isset( $attributes['ticketInfo'] ) ? $attributes['ticketInfo'] : false;
		$defaults          = array(
			'passer'           => 'shortcode',
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
			'cevents'          => $cevents,
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
			'category'         => $category,
			'slideheight'      => $slideheight,
			'imageheight'      => $imageheight,
			'ticketInfo'       => $ticket_info,
		);
		$args              = array_merge( $defaults, $attributes );
		return $tecslider->function->tecslider_generate_tec_events( $args );
	}
}
new Tecslider_Shortcodes();
