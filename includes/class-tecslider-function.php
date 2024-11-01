<?php

/**
 * Helper functions for Slider Addons
 *
 * @author  mokchya
 * @package tecslider
 * @version 1.0
 */
class Tecslider_Function {
    /**
     * Settings Option Name
     *
     * @var string
     */
    private $opname = 'tecslider_settings_options';

    /**
     * Plugin URL
     *
     * @var array
     */
    public $props;

    /**
     * Constructor
     */
    public function __construct() {
        $this->props = get_option( 'tecslider_settings_options' );
    }

    /**
     * Get Settings by type
     *
     * @param string $type Type name.
     */
    public function tecslider_get_settings_by_type( $type ) {
        $options = get_option( $this->opname );
        return ( isset( $options[$type] ) ? $options[$type] : array() );
    }

    /**
     * Get ICON Url
     *
     * @param string $icon_name Icon Name.
     */
    public function tecslider_get_svg_icon( $icon_name ) {
        global $tecslider;
        return $tecslider->tecslider_assets . '/icons/' . $icon_name . '.svg';
    }

    /**
     * Set Settings
     *
     * @param string $type Settings Type.
     * @param string $field Field name.
     * @param mixed  $data Data.
     */
    public function tecslider_set_settings( $type, $field, $data ) {
        $options = get_option( $this->opname );
        $options[$type][$field] = $data;
        return update_option( $this->opname, $options );
    }

    /**
     * Returns check option check or unchecked
     *
     * @param array  $settings Settings array.
     * @param string $key Option key.
     */
    public function tecslider_return_check_option( $settings, $key ) {
        $option = ( isset( $settings[$key] ) ? $settings[$key] : 'off' );
        if ( 'on' === $option ) {
            $check = 'checked="checked"';
        } else {
            $check = '';
        }
        return $check;
    }

    /**
     * Returns check option check or unchecked
     *
     * @param array  $settings Settings array.
     * @param string $key Option key.
     */
    public function tecslider_return_option_yesno( $settings, $key ) {
        $option = ( isset( $settings[$key] ) ? $settings[$key] : 'off' );
        return $option;
    }

    /**
     * Get Event Categories
     */
    public function tecslider_get_tribe_event_categories() {
        $terms = get_terms( array(
            'taxonomy'   => 'tribe_events_cat',
            'hide_empty' => false,
        ) );
        $categories = array();
        if ( !empty( $terms ) && !is_wp_error( $terms ) ) {
            foreach ( $terms as $term ) {
                $categories[] = array(
                    'id'   => $term->slug,
                    'text' => $term->name,
                );
            }
        }
        return $categories;
    }

    /**
     * Generate Events
     *
     * @param string $args Arguments.
     */
    public function tecslider_generate_tec_events( $args ) {
        $enable_location_icon = 'on';
        $enable_datetime_icon = 'on';
        $pastpresent = $args['pastpresent'];
        $noe = $args['noe'];
        $auto = ( 1 === (int) $args['auto'] ? 'true' : 'false' );
        $transition = $args['transition'];
        $eirow = $args['eirow'];
        $sirow = $args['sirow'];
        $color = ( empty( $args['color'] ) ? '#5a30f3' : $args['color'] );
        $sliderid = $args['slider_id'];
        $theme = $args['theme'];
        $eirow = ( 'singleevent' === $theme ? 1 : $eirow );
        $sirow = ( 'singleevent' === $theme ? 1 : $sirow );
        $newtab = $args['newtab'];
        $category = ( isset( $args['category'] ) ? $args['category'] : '' );
        $cevents = ( isset( $args['cevents'] ) ? $args['cevents'] : '' );
        $countdown_timer = ( isset( $args['countdown_timer'] ) ? $args['countdown_timer'] : false );
        $dots = ( isset( $args['dots'] ) ? $args['dots'] : false );
        $dots = ( 1 === (int) $dots ? 'true' : 'false' );
        $darkmode = ( isset( $args['darkmode'] ) ? $args['darkmode'] : false );
        $colormode = ( 1 === (int) $darkmode ? 'mwt-darkmode' : 'mwt-lightmode' );
        $slider_height = ( isset( $args['slideheight'] ) ? $args['slideheight'] : 300 );
        $image_height = ( isset( $args['imageheight'] ) ? $args['imageheight'] : 200 );
        $ticket_info = ( isset( $args['ticketInfo'] ) ? (bool) $args['ticketInfo'] : false );
        $title_font_face = $args['titleFontFace'];
        $title_font_size = $args['titleFontSize'];
        $desc_font_face = $args['descFontFace'];
        $desc_font_size = $args['descFontSize'];
        $dt_font_face = $args['datetimeFontFace'];
        $dt_font_size = $args['datetimeFontSize'];
        if ( 'upcoming' === $pastpresent ) {
            $start_date = gmdate( 'Y-m-d 00:00:00', time() );
            $end_date = gmdate( 'Y-m-d 23:59:59', strtotime( '+2 years', strtotime( $start_date ) ) );
        } elseif ( 'past' === $pastpresent ) {
            $end_date = gmdate( 'Y-m-d 23:59:59', time() );
            $start_date = gmdate( 'Y-m-d 00:00:00', strtotime( '-2 years' ) );
        }
        $args = array();
        if ( 'upcoming' === $pastpresent || 'past' === $pastpresent ) {
            $args = array(
                'start_date' => $start_date,
                'end_date'   => $end_date,
                'status'     => 'publish',
                'page'       => 1,
                'per_page'   => $noe,
            );
        } elseif ( 'custom' === $pastpresent ) {
            $enames = array();
            if ( !empty( $cevents ) ) {
                $events = json_decode( $cevents );
                if ( !empty( $events ) ) {
                    foreach ( $events as $event ) {
                        $enames[] = $event->value;
                    }
                }
            }
            $args = array(
                'posts_per_page' => -1,
                'status'         => 'publish',
                'post_name__in'  => $enames,
            );
        }
        if ( !empty( $category ) ) {
            $args['tax_query'] = array(array(
                'taxonomy' => 'tribe_events_cat',
                'field'    => 'slug',
                'terms'    => $category,
            ));
        }
        $events = tribe_get_events( $args );
        $slider_id = ( !empty( $sliderid ) ? $sliderid : uniqid( 'tec-slider-block-' ) );
        $slider_id_cid = '#' . $slider_id;
        $general = get_option( 'tecslider_general_settings' );
        $mwt_date_format = ( isset( $general['mwt_date_format'] ) ? $general['mwt_date_format'] : '' );
        $event_starts_in = ( isset( $general['event_starts_in'] ) ? $general['event_starts_in'] : '' );
        $event_ends_in = ( isset( $general['event_ends_in'] ) ? $general['event_ends_in'] : '' );
        $enable_location_icon = $this->tecslider_return_option_yesno( $general, 'enable_location_icon' );
        $enable_datetime_icon = $this->tecslider_return_option_yesno( $general, 'enable_datetime_icon' );
        $enable_organizer_icon = $this->tecslider_return_option_yesno( $general, 'enable_organizer_icon' );
        $remove_cd_zero_days = $this->tecslider_return_option_yesno( $general, 'remove_cd_zero_days' );
        $remove_cd_hours = $this->tecslider_return_option_yesno( $general, 'remove_cd_hours' );
        $remove_cd_minutes = $this->tecslider_return_option_yesno( $general, 'remove_cd_minutes' );
        $remove_cd_seconds = $this->tecslider_return_option_yesno( $general, 'remove_cd_seconds' );
        $date_format = tribe_get_option( 'tribe_events_date_format', Tribe__Date_Utils::DBDATEFORMAT );
        $date_format = ( !empty( $date_format ) ? $date_format : get_option( 'date_format' ) );
        $date_format = ( !empty( $date_format ) ? $date_format : 'F j, y' );
        $mwt_date_format = ( !empty( $mwt_date_format ) ? $mwt_date_format : $date_format );
        ob_start();
        ?>
		<div class="tec-slider-wrapper">
			<div class="tec-slider-container <?php 
        echo esc_attr( $theme );
        ?> <?php 
        echo esc_attr( $colormode );
        ?>" id="<?php 
        echo esc_attr( $slider_id );
        ?>">
			<?php 
        if ( $events ) {
            ?>
				<ul class="tec-slider-list"
					data-theme="<?php 
            echo esc_attr( $theme );
            ?>"
					data-speed="<?php 
            echo esc_html( $transition );
            ?>"
					data-slides="<?php 
            echo esc_html( $eirow );
            ?>"
					data-auto="<?php 
            echo esc_html( $auto );
            ?>"
					data-color="<?php 
            echo esc_html( $color );
            ?>"
					data-count="<?php 
            echo esc_html( count( $events ) );
            ?>"
					data-dots="<?php 
            echo esc_html( $dots );
            ?>"
					>
				<?php 
            $total = count( (array) $events );
            $countdowns = array();
            foreach ( (array) $events as $array_id => $event ) {
                setup_postdata( $event );
                $category_slugs = array();
                $category_list = get_the_terms( $event, 'tribe_events_cat' );
                if ( is_array( $category_list ) ) {
                    foreach ( (array) $category_list as $category ) {
                        $category_slugs[] = $category->slug;
                    }
                }
                $eimage = get_the_post_thumbnail_url( $event->ID );
                $month = tribe_get_start_date( $event, false, 'j' );
                $day = tribe_get_start_date( $event, false, 'M' );
                $venue = tribe_get_venue( $event->ID );
                $mclass = 'tec-slider-' . $theme;
                $li_id = $slider_id . '-' . $event->ID . '-single-slide-event';
                $tmz = Tribe__Events__Timezones::get_event_timezone_string( $event->ID );
                if ( $countdown_timer ) {
                    $countdowns[] = array(
                        'start' => tribe_get_start_date( $event, false, 'Y-m-d H:i:s' ),
                        'end'   => tribe_get_end_date( $event, false, 'Y-m-d H:i:s' ),
                        'id'    => $li_id,
                        'tmz'   => $tmz,
                    );
                }
                ?>
					<li data-url="<?php 
                echo esc_url( tribe_get_event_link( $event ) );
                ?>" class="tec-sse-single-link" data-id=<?php 
                echo esc_attr( $li_id );
                ?>>
						<div class="<?php 
                echo esc_attr( $mclass );
                ?> tec-slider-all-event">
							<?php 
                if ( 'datetop' === $theme ) {
                    ?>
								<?php 
                    if ( $ticket_info ) {
                        include 'tickets/tecslider-ticket-template.php';
                    }
                    ?>
								<div class="tec-sse-date">
									<div class="tec-sse-date-container">
										<div class="tec-sse-date-date">
											<?php 
                    echo esc_html( $month );
                    ?>
										</div>
										<div class="tec-sse-date-month">
											<?php 
                    echo esc_html( $day );
                    ?>
										</div>
									</div>
								</div>
								<div class="tec-sse-image" style="background-image:url(<?php 
                    echo esc_url( $eimage );
                    ?>);">
									<?php 
                    if ( $countdown_timer ) {
                        ?>
										<span class="tec-countdown">
											<span class="cd-info"></span>
											<span class="cd-datetime"></span>
										</span>
									<?php 
                    }
                    ?>
								</div>
								<div class="tec-sse-details">
									<?php 
                    $this->tecslider_generate_organizer( $event, $enable_organizer_icon );
                    ?>
									<div class="tec-slider-title">
										<?php 
                    echo esc_html( get_the_title( $event ) );
                    ?>
									</div>
									<?php 
                    $this->tecslider_generate_location( $event, $enable_location_icon );
                    ?>
								</div>
							<?php 
                } elseif ( 'coloredcard' === $theme ) {
                    ?>
								<?php 
                    if ( $ticket_info ) {
                        include 'tickets/tecslider-ticket-template.php';
                    }
                    ?>
								<div class="tec-sse-image" style="background-image:url(<?php 
                    echo esc_url( $eimage );
                    ?>);">
									<?php 
                    if ( $countdown_timer ) {
                        ?>
										<span class="tec-countdown">
											<span class="cd-info"></span>
											<span class="cd-datetime"></span>
										</span>
									<?php 
                    }
                    ?>
								</div>
								<div class="tec-sse-details">
									<?php 
                    $this->tecslider_generate_datetime( $event, $enable_datetime_icon, $mwt_date_format );
                    ?>
									<?php 
                    $this->tecslider_generate_organizer( $event, $enable_organizer_icon );
                    ?>
									<div class="tec-slider-title">
										<?php 
                    echo esc_html( get_the_title( $event ) );
                    ?>
									</div>
									<?php 
                    $this->tecslider_generate_location( $event, $enable_location_icon );
                    ?>
								</div>
							<?php 
                } elseif ( 'singleevent' === $theme ) {
                    ?>
								<div class="single-event-row">
									<div class="tec-sse-image" style="background-image:url(<?php 
                    echo esc_url( $eimage );
                    ?>);">
										<?php 
                    if ( $countdown_timer ) {
                        ?>
											<span class="tec-countdown">
												<span class="cd-info"></span>
												<span class="cd-datetime"></span>
											</span>
										<?php 
                    }
                    ?>
										<?php 
                    if ( $ticket_info ) {
                        include 'tickets/tecslider-ticket-template.php';
                    }
                    ?>
									</div>
									<div class="tec-sse-details">
										<div class="tec-sse-date">
											<div class="tec-sse-date-container">
												<div class="tec-sse-date-date">
													<?php 
                    echo esc_html( $month );
                    ?>
												</div>
												<div class="tec-sse-date-month">
													<?php 
                    echo esc_html( $day );
                    ?>
												</div>
											</div>
										</div>
										<?php 
                    $this->tecslider_generate_organizer( $event, $enable_organizer_icon );
                    ?>
										<div class="tec-slider-title">
											<?php 
                    echo esc_html( get_the_title( $event ) );
                    ?>
										</div>
										<?php 
                    $this->tecslider_generate_location( $event, $enable_location_icon );
                    ?>
										<div class="tec-sse-event-text">
											<?php 
                    echo esc_html( $this->tecslider_get_the_content( get_the_content( $event->ID ) ) );
                    ?>
										</div>
									</div>
								</div>
							<?php 
                } elseif ( 'imagemiddle' === $theme ) {
                    ?>
								<?php 
                    if ( $ticket_info ) {
                        include 'tickets/tecslider-ticket-template.php';
                    }
                    ?>
								<div class="image-middle-top">
									<div class="tec-slider-title">
										<?php 
                    echo esc_html( get_the_title( $event ) );
                    ?>
									</div>
									<?php 
                    $this->tecslider_generate_location( $event, $enable_location_icon );
                    ?>
									<?php 
                    $this->tecslider_generate_organizer( $event, $enable_organizer_icon );
                    ?>
									<?php 
                    $this->tecslider_generate_datetime(
                        $event,
                        $enable_datetime_icon,
                        $mwt_date_format,
                        $mwt_date_format
                    );
                    ?>
								</div>
								<div class="image-middle-center">
									<div class="tec-sse-image" style="background-image:url(<?php 
                    echo esc_url( $eimage );
                    ?>);">
										<?php 
                    if ( $countdown_timer ) {
                        ?>
											<span class="tec-countdown">
												<span class="cd-info"></span>
												<span class="cd-datetime"></span>
											</span>
										<?php 
                    }
                    ?>
									</div>
								</div>
								<div class="image-middle-bottom">
									<div class="tec-sse-event-text">
										<?php 
                    echo esc_html( $this->tecslider_get_the_content( get_the_content( $event->ID ) ) );
                    ?>
									</div>
								</div>
							<?php 
                } elseif ( 'overimage' === $theme ) {
                    ?>
								<?php 
                    if ( tsa_fs()->is_premium() ) {
                        ?>
									<?php 
                        ?>
								<?php 
                    }
                    ?>
							<?php 
                } elseif ( 'hoverdetail' === $theme ) {
                    ?>
								<?php 
                    if ( tsa_fs()->is_premium() ) {
                        ?>
									<?php 
                        ?>
								<?php 
                    }
                    ?>
							<?php 
                } elseif ( 'hoverflip' === $theme ) {
                    ?>
								<?php 
                    if ( tsa_fs()->is_premium() ) {
                        ?>
									<?php 
                        ?>
								<?php 
                    }
                    ?>
							<?php 
                }
                ?>
						</div>
					</li>
					<?php 
            }
            ?>
				</ul>
				<span class="contdown-data-holder" data-countdown="<?php 
            echo esc_attr( wp_json_encode( $countdowns ) );
            ?>"></span>
				<style id="tecsb-slider-block-inline-s">
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container .tec-slider-title{
						font-family: <?php 
            echo esc_html( $title_font_face );
            ?>;
						font-size: <?php 
            echo esc_html( $title_font_size );
            ?>px;
					}
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container .tec-sse-event-text{
						font-family: <?php 
            echo esc_html( $desc_font_face );
            ?>;
						font-size: <?php 
            echo esc_html( $desc_font_size );
            ?>px;
					}
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container .tec-sse-date{
						background: <?php 
            echo esc_html( $color );
            ?>;
					}
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container .slick-prev::before,
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container .slick-next::before{
						color: <?php 
            echo esc_html( $color );
            ?>;
					}
					<?php 
            if ( 'coloredcard' === $theme ) {
                ?>
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container.coloredcard .tec-sse-details{
							background: <?php 
                echo esc_html( $color );
                ?>;
						}
					<?php 
            }
            ?>
					<?php 
            if ( 'hoverdetail' === $theme ) {
                ?>
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .slick-prev::before,
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .slick-next::before{
							color: rgba( 0,0,0,0.8);
						}
					<?php 
            }
            ?>
					<?php 
            if ( 'overimage' === $theme ) {
                ?>
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .slick-prev::before,
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .slick-next::before{
							color: rgba( 255,255,255,0.8);
						}
					<?php 
            }
            ?>
					<?php 
            if ( 0 !== $dt_font_size ) {
                ?>
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .tec-sse-date-date{
							font-size: calc( 34px + ( <?php 
                echo esc_html( $dt_font_size );
                ?>px) );
						}
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .tec-sse-date-month,
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .tec-sse-date-inline,
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .tec-sse-venue,
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .tec-sse-organizer,
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container .tec-imdate-date-block{
							font-size: calc( 14px + ( <?php 
                echo esc_html( $dt_font_size );
                ?>px) );
						}
					<?php 
            }
            ?>
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container .tec-sse-date-container{
						font-family: <?php 
            echo esc_html( $dt_font_face );
            ?>;
					}
					<?php 
            echo esc_attr( $slider_id_cid );
            ?> ul.tec-slider-list li.tec-sse-single-link{
						height: 100%;
					}
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.hoverflip ul.tec-slider-list li.tec-sse-single-link{
						height: 370px;
					}
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container.datetop .tec-sse-details,
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container.coloredcard .tec-sse-details,
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container.singleevent .tec-sse-details,
					<?php 
            echo esc_attr( $slider_id_cid );
            ?>.tec-slider-container.imagemiddle .image-middle-bottom{
						height: <?php 
            echo esc_html( $slider_height );
            ?>px;
					}
					<?php 
            if ( 'hoverdetail' === $theme ) {
                ?>
						<?php 
                echo esc_attr( $slider_id_cid );
                ?> .tec-sse-image
							{
								height: <?php 
                echo esc_html( $image_height );
                ?>px;
							}
					<?php 
            }
            ?>
					<?php 
            if ( 'overimage' === $theme ) {
                ?>
						<?php 
                echo esc_attr( $slider_id_cid );
                ?>.tec-slider-container.overimage .tec-sse-image.tec-overimage-holder{
							height: <?php 
                echo esc_html( $image_height );
                ?>px;
						}
					<?php 
            }
            ?>
				</style>
				<script id="tecsb-slider-block-inline-j" type="text/javascript">
					jQuery(document).ready(function ($) {
						function fixHeightOfAll() {
							$('ul.tec-slider-list').each(function() {
								var $ul = $(this);

								// Get the maximum height of .tec-sse-details elements within this ul
								var maxHeight = 0;
								$ul.find('.tec-sse-details').each(function() {
									var height = $(this).outerHeight();
									if (height > maxHeight) {
										maxHeight = height;
									}
								});
								// Set the maximum height to all .tec-sse-details elements within this ul
								$ul.find('.tec-sse-details').css('height', maxHeight + 'px');

								$ul.find('.image-middle-top').each(function() {
									var height = $(this).outerHeight();
									if (height > maxHeight) {
										maxHeight = height;
									}
								});
								$ul.find('.image-middle-top').css('height', maxHeight + 'px');

								$ul.find('.hover-flip-info').each(function() {
									var height = $(this).outerHeight();
									if (height > maxHeight) {
										maxHeight = height;
									}
								});
								$ul.find('.hover-flip-info').css('height', maxHeight + 'px');
							});
						}
						// Function to calculate and display the countdown timer
						function enableAndUpdateCountdown(eventStartDate, eventEndDate, countdownElementId, etmz = null) {
							let countdownInterval;
							function updateCountdown() {
								const eventTimezone = etmz !== null ? etmz : momocountdown.tmz;
								const timeZoneOptions = { timeZone: eventTimezone };
								const nowtz = new Date().toLocaleString('en-US', timeZoneOptions);
								const now = new Date(nowtz).getTime();
								const eventStartDateTime = new Date(eventStartDate).getTime();
								const eventEndDateTime = new Date(eventEndDate).getTime();
								const countdownElement = jQuery( '[data-id="' + countdownElementId + '"]').find('.tec-countdown');
								const info = countdownElement.find('.cd-info');
								const datetime = countdownElement.find('.cd-datetime');
								if (now < eventStartDateTime) {
									// Event has not started yet
									const timeLeft = eventStartDateTime - now;
									const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
									const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
									const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
									const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);
									info.html(momocountdown.start);
									var html = '';
									html += ('off' === momocountdown.rmday) ? `${days}<span class="dhms">${momocountdown.dhmsd}</span> ` : '';
									html += ('off' === momocountdown.rmhrs) ? `${hours}<span class="dhms">${momocountdown.dhmsh}</span> ` : '';
									html += ('off' === momocountdown.rmmin) ? `${minutes}<span class="dhms">${momocountdown.dhmsm}</span> ` : '';
									html += ('off' === momocountdown.rmsec) ? `${seconds}<span class="dhms">${momocountdown.dhmss}</span> ` : '';

									datetime.html(html);
								} else if (now < eventEndDateTime) {
									// Event has started and is still running
									const timeLeft = eventEndDateTime - now;
									const days = Math.floor(timeLeft / (1000 * 60 * 60 * 24));
									const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
									const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
									const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

									info.html(momocountdown.endsin);
									var html = '';
									html += ('off' === momocountdown.rmday) ? `${days}<span class="dhms">${momocountdown.dhmsd}</span> ` : '';
									html += ('off' === momocountdown.rmhrs) ? `${hours}<span class="dhms">${momocountdown.dhmsh}</span> ` : '';
									html += ('off' === momocountdown.rmmin) ? `${minutes}<span class="dhms">${momocountdown.dhmsm}</span> ` : '';
									html += ('off' === momocountdown.rmsec) ? `${seconds}<span class="dhms">${momocountdown.dhmss}</span> ` : '';

									datetime.html(html);
								} else {
									// Event has ended
									info.html(momocountdown.end);
									clearInterval(countdownInterval); // Stop updating the countdown
								}
							}

							// Initial call to update the countdown
							updateCountdown();

							// Update the countdown every second
							countdownInterval = setInterval(updateCountdown, 1000);
							console.log('***Countdown Timer Started***');
							// Return a function to clear the interval when needed
							return function () {
								clearInterval(countdownInterval);
							};
						}

						jQuery('body').on('click', '.tec-sse-single-link', function (e) {
							e.preventDefault();
							e.stopImmediatePropagation();
							var url = $(this).data('url');
							<?php 
            if ( true === $newtab ) {
                ?>
								window.open(url, '_blank');
							<?php 
            } else {
                ?>
								window.open(url, '_self' );
							<?php 
            }
            ?>

							return;
						});
						jQuery('<?php 
            echo esc_attr( $slider_id_cid );
            ?> .tec-slider-list').slick({
							dots:<?php 
            echo esc_html( $dots );
            ?>,
							infinite: true,
							speed: <?php 
            echo esc_html( $transition );
            ?>,
							slidesToShow: <?php 
            echo esc_html( ( (int) $total >= $eirow ? $eirow : $total ) );
            ?>,
							slidesToScroll: <?php 
            echo esc_html( ( (int) $total >= $sirow ? $sirow : $total ) );
            ?>,
							adaptiveHeight: true,
							autoplay: <?php 
            echo esc_html( $auto );
            ?>,
							responsive: [
								{
								breakpoint: 1024,
								settings: {
									slidesToShow: <?php 
            echo ( (int) $eirow > 3 || $total > 3 ? 3 : 2 );
            ?>,
									slidesToScroll: <?php 
            echo ( (int) $sirow > 3 ? 3 : (int) $sirow );
            ?>,
									infinite: true,
									dots: <?php 
            echo esc_html( $dots );
            ?>
									}
								},
								{
								breakpoint: 600,
								settings: {
									slidesToShow: <?php 
            echo ( (int) $eirow > 2 || $total > 2 ? 2 : 1 );
            ?>,
									slidesToScroll: <?php 
            echo ( (int) $sirow > 2 ? 2 : (int) $sirow );
            ?>,
									infinite: true,
									dots:<?php 
            echo esc_html( $dots );
            ?>
									}
								},
								{
								breakpoint: 480,
								settings: {
									slidesToShow: 1,
									slidesToScroll: 1,
									infinite: true,
									dots:<?php 
            echo esc_html( $dots );
            ?>
									}
								}
							]
						});
						console.log('*** Running tecslider Block****');
						fixHeightOfAll();
						<?php 
            if ( $countdown_timer ) {
                ?>
							<?php 
                foreach ( $countdowns as $countdown ) {
                    ?>
								var start = '<?php 
                    echo esc_html( $countdown['start'] );
                    ?>';
								var end = '<?php 
                    echo esc_html( $countdown['end'] );
                    ?>';
								var eid = '<?php 
                    echo esc_html( $countdown['id'] );
                    ?>';
								var etmz = '<?php 
                    echo esc_html( $countdown['tmz'] );
                    ?>';
								enableAndUpdateCountdown( start, end, eid, etmz );
							<?php 
                }
                ?>
						<?php 
            }
            ?>
					});
				</script>
				<?php 
            wp_reset_postdata();
        } else {
            ?>
				<div class="tec-slider-notice">
					<?php 
            esc_html_e( 'Event not found.', 'tecslider' );
            ?>
				</div>
				<?php 
        }
        ?>
			</div><!-- tec-slider-container -->
		</div><!-- tec-slider-wrapper -->
		<?php 
        return ob_get_clean();
    }

    /**
     * Generate Location
     *
     * @param Tribe_Event $event Event.
     * @param string      $icon Icon enable disable.
     */
    public function tecslider_generate_location( $event, $icon ) {
        $location = tribe_get_venue( $event );
        if ( empty( $location ) ) {
            return;
        }
        ob_start();
        ?>
		<div class="tec-sse-venue">
			<?php 
        if ( 'on' === $icon ) {
            ?>
				<i class="tecslider-fe-icons tfi-venue bx bxs-map"></i>
				<?php 
        }
        ?>
			<?php 
        echo esc_html( $location );
        ?>
		</div>
		<?php 
        return ob_get_flush();
    }

    /**
     * Generate Datetime
     *
     * @param Tribe_Event $event Event.
     * @param string      $icon Icon enable disable.
     * @param string      $format Format.
     */
    public function tecslider_generate_datetime( $event, $icon, $format ) {
        ob_start();
        ?>
		<div class="tec-sse-date-inline">
			<?php 
        if ( 'on' === $icon ) {
            ?>
				<i class="tecslider-fe-icons tfi-datetime bx bxs-calendar"></i>
				<?php 
        }
        ?>
			<?php 
        echo esc_html( tribe_get_start_date( $event, true, $format ) );
        ?>
		</div>
		<?php 
        return ob_get_flush();
    }

    /**
     * Generate Location
     *
     * @param Tribe_Event $event Event.
     * @param string      $icon Icon enable disable.
     */
    public function tecslider_generate_organizer( $event, $icon ) {
        $organizer = tribe_get_organizer( $event );
        if ( empty( $organizer ) ) {
            return;
        }
        ob_start();
        ?>
		<div class="tec-sse-organizer">
			<?php 
        if ( 'on' === $icon ) {
            ?>
				<i class="tecslider-fe-icons tfi-organizer bx bx-station"></i>
				<?php 
        }
        ?>
			<?php 
        echo esc_html( $organizer );
        ?>
		</div>
		<?php 
        return ob_get_flush();
    }

    /**
     * Returns a limited version of the provided content with a specified word limit and ellipsis.
     *
     * @param string $content The content to be limited.
     * @param int    $word_limit The maximum number of words to include in the limited content.
     * @param string $ellipsis The ellipsis to add if the content exceeds the word limit.
     */
    public function tecslider_get_the_content( $content, $word_limit = 20, $ellipsis = '...' ) {
        $general = get_option( 'tecslider_general_settings' );
        $word_limit = ( isset( $general['desc_word_count'] ) && !empty( $general['desc_word_count'] ) ? $general['desc_word_count'] : $word_limit );
        $content = strip_shortcodes( $content );
        $words = explode( ' ', $content );
        $limited_content = implode( ' ', array_slice( $words, 0, $word_limit ) );
        if ( count( $words ) > $word_limit ) {
            $limited_content .= $ellipsis;
        }
        return $limited_content;
    }

}
