<?php
/**
 * Blocks for Slider addons
 *
 * @author  mywptrek
 * @package tecsb
 * @version 1.0
 */
class Tecslider_Blocks {
	/**
	 * Server Side Render callback
	 *
	 * @param array $attributes Attributes array.
	 */
	public function render_block_core_archives_tecsb( $attributes ) {
		global $tecslider;
		wp_enqueue_script( 'tecslider-script', $tecslider->plugin_url . '/assets/slick/slick.min.js', array( 'jquery' ), $tecslider->version, true );
		wp_enqueue_style( 'tecslider-styles', $tecslider->plugin_url . '/assets/slick/slick.css', array(), $tecslider->version );
		wp_enqueue_style( 'tecslider-tmeme-styles', $tecslider->plugin_url . '/assets/slick/slick-theme.css', array(), $tecslider->version );
		$no_of_events      = 5;
		$theme_selected    = isset( $attributes['sliderTheme'] ) ? $attributes['sliderTheme'] : 'datetop';
		$slider_type       = isset( $attributes['sliderType'] ) ? $attributes['sliderType'] : 'upcoming';
		$event_in_row      = isset( $attributes['eventInRow'] ) ? $attributes['eventInRow'] : 3;
		$event_in_slide    = isset( $attributes['eventInSlide'] ) ? $attributes['eventInSlide'] : 3;
		$auto_play         = isset( $attributes['autoPlay'] ) ? $attributes['autoPlay'] : true;
		$transition_delay  = isset( $attributes['transitionDelay'] ) ? $attributes['transitionDelay'] : 200;
		$color_scheme      = isset( $attributes['colorScheme'] ) ? $attributes['colorScheme'] : '#5a30f3';
		$slider_id         = isset( $attributes['blockId'] ) ? $attributes['blockId'] : false;
		$venue_enabled     = isset( $attributes['venueEnabled'] ) ? $attributes['venueEnabled'] : false;
		$organizer_enabled = isset( $attributes['organizerEnabled'] ) ? $attributes['organizerEnabled'] : false;
		$custom_events     = isset( $attributes['customSelectedEvents'] ) ? $attributes['customSelectedEvents'] : false;
		$newtab            = isset( $attributes['newtab'] ) ? $attributes['newtab'] : true;
		$category          = isset( $attributes['category'] ) ? $attributes['category'] : '';
		$plugin            = isset( $attributes['plugin'] ) ? $attributes['plugin'] : '';
		$title_font        = isset( $attributes['titleFontFace'] ) ? $attributes['titleFontFace'] : '';
		$title_size        = isset( $attributes['titleFontSize'] ) ? $attributes['titleFontSize'] : '20';
		$desc_font         = isset( $attributes['descFontFace'] ) ? $attributes['descFontFace'] : '';
		$desc_size         = isset( $attributes['descFontSize'] ) ? $attributes['descFontSize'] : '14';
		$dt_font           = isset( $attributes['datetimeFontFace'] ) ? $attributes['datetimeFontFace'] : '';
		$dt_size           = isset( $attributes['datetimeFontSize'] ) ? $attributes['datetimeFontSize'] : 0;
		$countdown_timer   = isset( $attributes['countdownTimer'] ) ? $attributes['countdownTimer'] : false;
		$dots              = isset( $attributes['dots'] ) ? $attributes['dots'] : false;
		$darkmode          = isset( $attributes['darkmode'] ) ? $attributes['darkmode'] : false;
		$slideheight       = isset( $attributes['slideHeight'] ) ? $attributes['slideHeight'] : 300;
		$imageheight       = isset( $attributes['imageHeight'] ) ? $attributes['imageHeight'] : 200;
		$ticket_info       = isset( $attributes['ticketInfo'] ) ? $attributes['ticketInfo'] : false;
		$args              = array(
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
			'cevents'          => $custom_events,
			'newtab'           => $newtab,
			'category'         => $category,
			'plugin'           => $plugin,
			'titleFontFace'    => $title_font,
			'titleFontSize'    => $title_size,
			'descFontFace'     => $desc_font,
			'descFontSize'     => $desc_size,
			'datetimeFontFace' => $dt_font,
			'datetimeFontSize' => $dt_size,
			'countdown_timer'  => $countdown_timer,
			'dots'             => $dots,
			'darkmode'         => $darkmode,
			'slideheight'      => $slideheight,
			'imageheight'      => $imageheight,
			'ticketInfo'       => $ticket_info,
		);
		$events            = $tecslider->function->tecslider_generate_tec_events( $args );
		return $events;
	}
}
new Tecslider_Blocks();
