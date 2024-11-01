<?php
/**
 * Admin Menu page - currently for tutorials
 *
 * @author mywptrek
 * @package tecslider
 */

global $tecslider;
$header_logo    = $tecslider->plugin_url . '/assets/admin/img/icon-256x256.png';
$select_block   = $tecslider->plugin_url . '/assets/admin/img/select-slider-block.png';
$settings_block = $tecslider->plugin_url . '/assets/admin/img/block-settings-sidebar.png';
$theme_one      = $tecslider->plugin_url . '/assets/admin/img/theme-1.gif';
$theme_two      = $tecslider->plugin_url . '/assets/admin/img/theme-2.gif';
$theme_three    = $tecslider->plugin_url . '/assets/admin/img/theme-3.gif';
?>
<div class="tecslider-admin-container">
	<div class="tecslider-admin-header">
		<span class="tecslider-admin-header-logo">
			<img src="<?php echo esc_url( $header_logo ); ?>"/>
		</span>
		<span class="tecslider-admin-header-text">
			<?php
			esc_html_e( 'Slider addons for The Events Calendar', 'tecslider' );
			?>
		</span>
	</div>
	<div class="tecslider-admin-divider"></div>
	<div class="clear"></div>
	<div class="tecslider-admin-row-flex">
		<div class="tecslider-admin-flex-col">
			<ul class="tecslider-instruction-list">
				<li>
					<?php
					esc_html_e( 'Search for Tecsb Events Slider in block search box.', 'tecslider' );
					?>
				</li>
				<li>
					<?php
					esc_html_e( 'Select block as shown in screenshot.', 'tecslider' );
					?>
				</li>
			</ul>
		</div>
		<div class="tecslider-admin-flex-col tecslider-admin-center">
			<img class="tecslider-admin-select-block" src="<?php echo esc_url( $select_block ); ?>" />
		</div>
	</div>
	<div class="clear"></div>
	<div class="tecslider-admin-divider"></div>
	<div class="tecslider-admin-row-flex">
		<div class="tecslider-admin-flex-col tecslider-admin-center">
			<img class="tecslider-admin-settings-block" src="<?php echo esc_url( $settings_block ); ?>" />
		</div>
		<div class="tecslider-admin-flex-col">
			<h2>
			<?php
			esc_html_e( 'Select various options for slider from side settings panel.', 'tecslider' );
			?>
			</h2>
			<ul class="tecslider-instruction-list number">
				<li>
					<?php
					esc_html_e( 'Upcoming or past events to show.', 'tecslider' );
					?>
				</li>
				<li>
					<?php
					esc_html_e( 'Select three different themes.', 'tecslider' );
					?>
				</li>
				<li>
					<?php
					esc_html_e( 'Number of events to display at one time.', 'tecslider' );
					?>
				</li>
				<li>
					<?php
					esc_html_e( 'Auto slide events on page load.', 'tecslider' );
					?>
				</li>
				<li>
					<?php
					esc_html_e( 'Transition time on slide change.', 'tecslider' );
					?>
				</li>
				<li>
					<?php
					esc_html_e( 'Color for colors used inside theme.', 'tecslider' );
					?>
				</li>
				<li>
					<?php
					esc_html_e( 'Added: Choose number of events to slide.', 'tecslider' );
					?>
				</li>
			</ul>
		</div>
	</div>
	<div class="clear"></div>
	<div class="tecslider-admin-divider"></div>
	<div class="tecslider-admin-row">
		<div class="tecslider-admin-h1">
			<?php
			esc_html_e( 'Current Available Themes Preview', 'tecslider' );
			?>
		</div>
	</div>
	<div class="tecslider-admin-divider"></div>
	<div class="tecslider-admin-row">
		<div class="tecslider-admin-h2">
			<?php
			esc_html_e( 'Date Top', 'tecslider' );
			?>
		</div>
		<div class="tecslider-admin-preview-container">
			<img src="<?php echo esc_url( $theme_one ); ?>"/>
		</div>
	</div>
	<div class="tecslider-admin-divider"></div>
	<div class="tecslider-admin-row">
		<div class="tecslider-admin-h2">
			<?php
			esc_html_e( 'Colored Card', 'tecslider' );
			?>
		</div>
		<div class="tecslider-admin-preview-container">
			<img src="<?php echo esc_url( $theme_two ); ?>"/>
		</div>
	</div>
	<div class="tecslider-admin-divider"></div>
	<div class="tecslider-admin-row">
		<div class="tecslider-admin-h2">
			<?php
			esc_html_e( 'Single Event', 'tecslider' );
			?>
		</div>
		<div class="tecslider-admin-preview-container">
			<img src="<?php echo esc_url( $theme_three ); ?>"/>
		</div>
	</div>
</div>
