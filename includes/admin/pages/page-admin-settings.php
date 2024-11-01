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
$desc_word_count = isset( $general['desc_word_count'] ) ? $general['desc_word_count'] : 20;

$is_premium       = tsa_fs()->is_premium();
$is_premium_block = ! $is_premium ? 'mwt-premium-block' : '';
$is_disabled      = ! $is_premium ? "disabled='disabled'" : '';
?>
<div class="text header">
	<?php esc_html_e( 'Settings', 'tecslider' ); ?>
</div>
<div class="mwt-be-hr-line"></div>
<div class="mwt-be-section">
	<h2 class="mwt-be-section-header">
		<?php esc_html_e( 'Icons', 'tecslider' ); ?>
	</h2>
	<div class="mwt-be-block">
		<span class="mwt-be-toggle-container">
			<label class="switch">
				<?php
				$name    = 'enable_location_icon';
				$name_id = 'tecslider_general_settings[' . $name . ']';
				$value   = $tecslider->function->tecslider_return_check_option( $general, $name );
				?>
				<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> >
				<span class="switch-label" data-on="Yes" data-off="No"></span>
				<span class="switch-handle"></span>
			</label>
		</span>
		<span class="mwt-be-toggle-container-label">
			<?php esc_html_e( 'Enable Location Icon', 'tecslider' ); ?>
		</span>
		<i class="mwt-be-label-icon bx bxs-map"></i>
	</div>
	<div class="mwt-be-block">
		<span class="mwt-be-toggle-container">
			<label class="switch">
				<?php
				$name    = 'enable_datetime_icon';
				$name_id = 'tecslider_general_settings[' . $name . ']';
				$value   = $tecslider->function->tecslider_return_check_option( $general, $name );
				?>
				<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> >
				<span class="switch-label" data-on="Yes" data-off="No"></span>
				<span class="switch-handle"></span>
			</label>
		</span>
		<span class="mwt-be-toggle-container-label">
			<?php esc_html_e( 'Enable DateTime Icon', 'tecslider' ); ?>
		</span>
		<i class="mwt-be-label-icon bx bxs-calendar"></i>
	</div>
	<div class="mwt-be-block">
		<span class="mwt-be-toggle-container">
			<label class="switch">
				<?php
				$name    = 'enable_organizer_icon';
				$name_id = 'tecslider_general_settings[' . $name . ']';
				$value   = $tecslider->function->tecslider_return_check_option( $general, $name );
				?>
				<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> >
				<span class="switch-label" data-on="Yes" data-off="No"></span>
				<span class="switch-handle"></span>
			</label>
		</span>
		<span class="mwt-be-toggle-container-label">
			<?php esc_html_e( 'Enable Organizer Icon', 'tecslider' ); ?>
		</span>
		<i class="mwt-be-label-icon bx bx-station"></i>
	</div>
</div>
<div class="mwt-be-hr-line"></div>
<div class="mwt-be-section">
	<h2 class="mwt-be-section-header">
		<?php esc_html_e( 'Event Description', 'tecslider' ); ?>
	</h2>
	<div class="mwt-be-block">
		<span class="mwt-be-label">
			<?php esc_html_e( 'Event description word(s) count', 'tecslider' ); ?>
		</span>
		<input type="number" class="mwt-regular mwt-wide" name="tecslider_general_settings[desc_word_count]" value="<?php echo esc_attr( $desc_word_count ); ?>" placeholder="<?php echo esc_attr( 20 ); ?>"/>
	</div>
</div>
<div class="mwt-be-hr-line"></div>
<div class="mwt-be-section">
	<h2 class="mwt-be-section-header">
		<?php esc_html_e( 'Datetime Settings', 'tecslider' ); ?>
	</h2>
	<div class="mwt-be-block">
		<span class="mwt-be-label">
			<?php esc_html_e( 'Date format that displays on slider card', 'tecslider' ); ?>
		</span>
		<input type="text" class="mwt-regular mwt-wide" name="tecslider_general_settings[mwt_date_format]" placeholder="<?php echo esc_attr( $date_format ); ?>" value="<?php echo esc_attr( $mwt_date_format ); ?>"/>
	</div>
</div>
<div class="mwt-be-hr-line"></div>
<div class="mwt-be-section <?php echo esc_html( $is_premium_block ); ?>">
	<h2 class="mwt-be-section-header">
		<?php esc_html_e( 'Countdown Timer', 'tecslider' ); ?>
		<?php
		if ( ! $is_premium ) {
			?>
			<span class="mwt-premium-badge"><?php esc_html_e( 'Premium', 'tecslider' ); ?></span>
			<?php
		}
		?>
	</h2>
	<div class="mwt-be-block">
		<span class="mwt-be-label">
			<?php esc_html_e( 'Event starts in', 'tecslider' ); ?>
		</span>
		<input type="text" class="mwt-regular mwt-wide" name="tecslider_general_settings[event_starts_in]" placeholder="<?php esc_html_e( 'Event starts in ...', 'tecslider' ); ?>" value="<?php echo esc_attr( $event_starts_in ); ?>" <?php echo esc_html( $is_disabled ); ?>/>
	</div>
	<div class="mwt-be-block">
		<span class="mwt-be-label">
			<?php esc_html_e( 'Event ends in', 'tecslider' ); ?>
		</span>
		<input type="text" class="mwt-regular mwt-wide" name="tecslider_general_settings[event_ends_in]" placeholder="<?php esc_html_e( 'Event ends in ...', 'tecslider' ); ?>" value="<?php echo esc_attr( $event_ends_in ); ?>" <?php echo esc_html( $is_disabled ); ?>/>
	</div>
	<div class="mwt-be-block">
		<span class="mwt-be-label">
			<?php esc_html_e( 'Event ended', 'tecslider' ); ?>
		</span>
		<input type="text" class="mwt-regular mwt-wide" name="tecslider_general_settings[event_has_ended]" placeholder="<?php esc_html_e( 'Event has ended.', 'tecslider' ); ?>" value="<?php echo esc_attr( $event_has_ended ); ?>" <?php echo esc_html( $is_disabled ); ?>/>
	</div>
	<div class="mwt-be-block">
		<span class="mwt-be-toggle-container">
			<label class="switch">
				<?php
				$name    = 'remove_cd_zero_days';
				$name_id = 'tecslider_general_settings[' . $name . ']';
				$value   = $tecslider->function->tecslider_return_check_option( $general, $name );
				?>
				<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> <?php echo esc_html( $is_disabled ); ?> >
				<span class="switch-label" data-on="Yes" data-off="No"></span>
				<span class="switch-handle"></span>
			</label>
		</span>
		<span class="mwt-be-toggle-container-label">
			<?php esc_html_e( 'Remove Day(s) with zero (0)', 'tecslider' ); ?>
		</span>
	</div>
	<div class="mwt-be-block">
		<span class="mwt-be-toggle-container">
			<label class="switch">
				<?php
				$name    = 'remove_cd_hours';
				$name_id = 'tecslider_general_settings[' . $name . ']';
				$value   = $tecslider->function->tecslider_return_check_option( $general, $name );
				?>
				<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> <?php echo esc_html( $is_disabled ); ?> >
				<span class="switch-label" data-on="Yes" data-off="No"></span>
				<span class="switch-handle"></span>
			</label>
		</span>
		<span class="mwt-be-toggle-container-label">
			<?php esc_html_e( 'Remove Hour(s)', 'tecslider' ); ?>
		</span>
	</div>
	<div class="mwt-be-block">
		<span class="mwt-be-toggle-container">
			<label class="switch">
				<?php
				$name    = 'remove_cd_minutes';
				$name_id = 'tecslider_general_settings[' . $name . ']';
				$value   = $tecslider->function->tecslider_return_check_option( $general, $name );
				?>
				<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> <?php echo esc_html( $is_disabled ); ?> >
				<span class="switch-label" data-on="Yes" data-off="No"></span>
				<span class="switch-handle"></span>
			</label>
		</span>
		<span class="mwt-be-toggle-container-label">
			<?php esc_html_e( 'Remove Minute(s)', 'tecslider' ); ?>
		</span>
	</div>
	<div class="mwt-be-block">
		<span class="mwt-be-toggle-container">
			<label class="switch">
				<?php
				$name    = 'remove_cd_seconds';
				$name_id = 'tecslider_general_settings[' . $name . ']';
				$value   = $tecslider->function->tecslider_return_check_option( $general, $name );
				?>
				<input type="checkbox" class="switch-input" name="<?php echo esc_attr( $name_id ); ?>" autocomplete="off" <?php echo esc_attr( $value ); ?> <?php echo esc_html( $is_disabled ); ?> >
				<span class="switch-label" data-on="Yes" data-off="No"></span>
				<span class="switch-handle"></span>
			</label>
		</span>
		<span class="mwt-be-toggle-container-label">
			<?php esc_html_e( 'Remove Second(s)', 'tecslider' ); ?>
		</span>
	</div>
</div>
