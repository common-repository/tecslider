<?php
/**
 * EventGlide - Settings Page
 *
 * @author mywptrek
 * @package tecslider
 * @since v1.0.0
 */

global $tecslider;
$date_format = get_option( 'tec_date_format' );
$date_format = ! empty( $date_format ) ? $date_format : get_option( 'date_format' );
$general     = get_option( 'tecslider_general_settings' );

$mwt_date_format = isset( $general['mwt_date_format'] ) ? $general['mwt_date_format'] : '';
$event_starts_in = isset( $general['event_starts_in'] ) ? $general['event_starts_in'] : '';
$event_ends_in   = isset( $general['event_ends_in'] ) ? $general['event_ends_in'] : '';
$event_has_ended = isset( $general['event_has_ended'] ) ? $general['event_has_ended'] : '';

$events = tribe_get_events(
	array(
		'posts_per_page' => -1,
	)
);

$is_premium   = tsa_fs()->is_premium();
$is_disabled  = ! $is_premium ? "disabled='disabled'" : '';
$premium_only = ! $is_premium ? ' ( Premium )' : '';
?>
<div class="text header">
	<?php esc_html_e( 'Shortcode', 'tecslider' ); ?>
</div>
<div class="mwt-be-hr-line"></div>
<div class="mwt-row">
	<div class="mwt-col">
		<div class="mwt-be-section">
			<h2 class="mwt-be-section-header">
				<?php esc_html_e( 'Event Type', 'tecslider' ); ?>
			</h2>
			<div class="mwt-be-block">
				<select name="tecslider_event_type" class="mwt-shortcode-element" data-attr="slidertype">
					<option value="upcoming"><?php esc_html_e( 'Upcoming', 'tecslider' ); ?></option>
					<option value="past"><?php esc_html_e( 'Past', 'tecslider' ); ?></option>
					<option value="custom" <?php echo esc_html( $is_disabled ); ?> ><?php esc_html_e( 'Custom', 'tecslider' ); ?><?php echo esc_html( $premium_only ); ?></option>
				</select>
			</div>
		</div>
	</div>
	<div class="mwt-col mwt-p-col"></div>
	<div class="mwt-col">
		<div class="mwt-be-section">
			<h2 class="mwt-be-section-header">
				<?php esc_html_e( 'Select Theme', 'tecslider' ); ?>
			</h2>
			<div class="mwt-be-block">
				<select name="tecslider_theme" class="mwt-shortcode-element" data-attr="slidertheme">
					<option value="datetop"><?php esc_html_e( 'Date Top', 'tecslider' ); ?></option>
					<option value="coloredcard"><?php esc_html_e( 'Colored Card', 'tecslider' ); ?></option>
					<option value="singleevent"><?php esc_html_e( 'Single Event', 'tecslider' ); ?></option>
					<option value="imagemiddle" <?php echo esc_html( $is_disabled ); ?> ><?php esc_html_e( 'Image Middle', 'tecslider' ); ?><?php echo esc_html( $premium_only ); ?></option>
					<option value="overimage" <?php echo esc_html( $is_disabled ); ?> ><?php esc_html_e( 'Over Image', 'tecslider' ); ?><?php echo esc_html( $premium_only ); ?></option>
					<option value="hoverdetail" <?php echo esc_html( $is_disabled ); ?> ><?php esc_html_e( 'Hover Detail', 'tecslider' ); ?><?php echo esc_html( $premium_only ); ?></option>
					<option value="hoverflip" <?php echo esc_html( $is_disabled ); ?> ><?php esc_html_e( 'Flip on Hover', 'tecslider' ); ?><?php echo esc_html( $premium_only ); ?></option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="mwt-be-hr-line no-line"></div>
<div class="mwt-row mwt-hide shortcode-custom-events-row">
	<div class="mwt-col">
		<div class="mwt-be-section">
			<h2 class="mwt-be-section-header">
				<?php esc_html_e( 'Select Event(s)', 'tecslider' ); ?>
			</h2>
			<div class="mwt-be-block">
				<select multiple="multiple" name="cevents[]" class="mwt-shortcode-element" data-attr="cevents">
				<?php
				foreach ( $events as $event ) {
					$event_id    = $event->ID;
					$event_title = get_the_title( $event_id );

					echo '<option value="' . esc_attr( $event_id ) . '">' . esc_html( $event_title ) . '</option>';
				}
				?>
				</select>
			</div>
		</div>
	</div>
	<div class="mwt-col mwt-p-col"></div>
	<div class="mwt-col">
	</div>
</div>
<div class="mwt-be-hr-line"></div>
<div class="mwt-row">
	<div class="mwt-col">
		<div class="mwt-be-section">
			<h2 class="mwt-be-section-header">
				<?php esc_html_e( 'Event Count', 'tecslider' ); ?>
			</h2>
			<div class="mwt-be-block">
				<select name="tecslider_event_count" class="mwt-shortcode-element" data-attr="eventinrow">
					<option value="1"><?php esc_html_e( '1', 'tecslider' ); ?></option>
					<option value="2"><?php esc_html_e( '2', 'tecslider' ); ?></option>
					<option value="3"><?php esc_html_e( '3', 'tecslider' ); ?></option>
					<option value="3"><?php esc_html_e( '4', 'tecslider' ); ?></option>
				</select>
			</div>
		</div>
	</div>
	<div class="mwt-col mwt-p-col"></div>
	<div class="mwt-col">
		<div class="mwt-be-section">
			<h2 class="mwt-be-section-header" class="mwt-shortcode-element">
				<?php esc_html_e( 'Events on Slide', 'tecslider' ); ?>
			</h2>
			<div class="mwt-be-block">
				<select name="tecslider_event_on_slide" class="mwt-shortcode-element" data-attr="eventinslide">
					<option value="1"><?php esc_html_e( '1', 'tecslider' ); ?></option>
					<option value="2"><?php esc_html_e( '2', 'tecslider' ); ?></option>
					<option value="3"><?php esc_html_e( '3', 'tecslider' ); ?></option>
					<option value="3"><?php esc_html_e( '4', 'tecslider' ); ?></option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="mwt-be-hr-line"></div>
<div class="mwt-row">
	<div class="mwt-col">
		<div class="mwt-be-section">
			<h2 class="mwt-be-section-header">
				<?php esc_html_e( 'Options', 'tecslider' ); ?>
			</h2>
			<div class="mwt-be-block">
				<span class="mwt-be-toggle-container">
					<label class="switch">
						<?php
						$name = 'enable_countdown_timer';
						?>
						<input type="checkbox" class="switch-input mwt-shortcode-element" name="<?php echo esc_attr( $name ); ?>" autocomplete="off" data-attr="countdowntimer" <?php echo esc_html( $is_disabled ); ?> >
						<span class="switch-label" data-on="Yes" data-off="No"></span>
						<span class="switch-handle"></span>
					</label>
				</span>
				<span class="mwt-be-toggle-container-label">
					<?php esc_html_e( 'Countdown Timer', 'tecslider' ); ?>
				</span>
				<?php
				if ( ! $is_premium ) {
					?>
					<span class="mwt-premium-badge"><?php esc_html_e( 'Premium', 'tecslider' ); ?></span>
					<?php
				}
				?>
			</div>
			<div class="mwt-be-block">
				<span class="mwt-be-toggle-container">
					<label class="switch">
						<?php
						$name = 'auto_start_and_slide';
						?>
						<input type="checkbox" class="switch-input mwt-shortcode-element" name="<?php echo esc_attr( $name ); ?>" autocomplete="off" data-attr="autoplay">
						<span class="switch-label" data-on="Yes" data-off="No"></span>
						<span class="switch-handle"></span>
					</label>
				</span>
				<span class="mwt-be-toggle-container-label">
					<?php esc_html_e( 'Auto Start and Slide', 'tecslider' ); ?>
				</span>
			</div>
			<div class="mwt-be-block">
				<span class="mwt-be-toggle-container">
					<label class="switch">
						<?php
						$name = 'open_in_new_tab';
						?>
						<input type="checkbox" class="switch-input mwt-shortcode-element" name="<?php echo esc_attr( $name ); ?>" autocomplete="off" data-attr="newtab">
						<span class="switch-label" data-on="Yes" data-off="No"></span>
						<span class="switch-handle"></span>
					</label>
				</span>
				<span class="mwt-be-toggle-container-label">
					<?php esc_html_e( 'Open Event in New Tab', 'tecslider' ); ?>
				</span>
			</div>
			<?php if ( class_exists( 'Tribe__Tickets__Tickets' ) ) { ?>
			<div class="mwt-be-block">
				<span class="mwt-be-toggle-container">
					<label class="switch">
						<?php
						$name = 'display_ticket_info';
						?>
						<input type="checkbox" class="switch-input mwt-shortcode-element" name="<?php echo esc_attr( $name ); ?>" autocomplete="off" data-attr="ticketinfo">
						<span class="switch-label" data-on="Yes" data-off="No"></span>
						<span class="switch-handle"></span>
					</label>
				</span>
				<span class="mwt-be-toggle-container-label">
					<?php esc_html_e( 'Display Ticket Info', 'tecslider' ); ?>
				</span>
			</div>
			<?php } // ends ticket info. ?>
		</div>
	</div>
	<div class="mwt-col mwt-p-col"></div>
	<div class="mwt-col">
		<div class="mwt-be-section">
			<h2 class="mwt-be-section-header">
				<?php esc_html_e( 'Transitions ( in ms )', 'tecslider' ); ?>
			</h2>
			<div class="mwt-be-block">
				<select name="tecslider_slide_transition" class="mwt-shortcode-element" data-attr="transitiondelay">
					<option value="200"><?php esc_html_e( '200', 'tecslider' ); ?></option>
					<option value="400"><?php esc_html_e( '400', 'tecslider' ); ?></option>
					<option value="600"><?php esc_html_e( '600', 'tecslider' ); ?></option>
					<option value="800"><?php esc_html_e( '800', 'tecslider' ); ?></option>
					<option value="1000"><?php esc_html_e( '1000', 'tecslider' ); ?></option>
				</select>
			</div>
		</div>
	</div>
</div>
<div class="mwt-be-hr-line"></div>
<div class="mwt-be-section">
	<h2 class="mwt-be-section-header">
		<?php esc_html_e( 'Result', 'tecslider' ); ?>
	</h2>
	<div class="mwt-be-block">
		<div class="mwt-be-code" id="tecslider-shortcode">
			<code class="code">[add_mwt_tec_slider]</code>
		</div>
		<span class="mwt-copy-info"><?php esc_html_e( 'Copied to clipboard', 'tecslider' ); ?></span>
	</div>
</div>
