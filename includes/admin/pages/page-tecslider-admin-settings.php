<?php
/**
 * Eventglide Pro Settings Page
 *
 * @package tecslider
 * @author mywptrek
 */

global $tecslider;
$general = $tecslider->function->tecslider_get_settings_by_type( 'general' );
$mode_   = isset( $general['mode'] ) && ! empty( $general['mode'] ) ? $general['mode'] : 'light';
?>
<div class="wrap <?php echo esc_attr( $mode_ ); ?>" id="tecslider-settings-page">
	<nav class="sidebar">
		<header>
			<div class="image-text">
				<span class="logo light-logo">
					<img src="<?php echo esc_url( $tecslider->function->tecslider_get_svg_icon( 'calendar' ) ); ?>" alt="logo"/>
				</span>
				<span class="logo dark-logo">
					<img src="<?php echo esc_url( $tecslider->function->tecslider_get_svg_icon( 'calendar-inverted' ) ); ?>" alt="logo"/>
				</span>

				<div class="text header-text">
					<span class="name">
						<?php esc_html_e( 'EventGlide', 'tecslider' ); ?>
					</span>
					<span class="subname">
						<?php esc_html_e( 'Slider Elegance', 'tecslider' ); ?>
					</span>
				</div>
				<i class="toggle bx bx-chevron-right"></i>
			</div>
		</header>
		<div class="menu-bar">
			<div class="menu">
				<ul class="menu-links">
					<li class="nav-link">
						<a href="#settings" class="active">
							<i class="bx bx-cog icon"></i>
							<span class="text nav-text">
								<?php esc_html_e( 'Settings', 'tecslider' ); ?>
							</span>
						</a>
					</li>
					<li class="nav-link">
						<a href="#shortcode">
							<i class='bx bx-code-alt icon'></i>
							<span class="text nav-text">
								<?php esc_html_e( 'Shortcode', 'tecslider' ); ?>
							</span>
						</a>
					</li>
					<?php do_action( 'tecslider_admin_menu' ); ?>
					<li class="nav-link">
						<a href="#instructions">
							<i class='bx bxs-help-circle icon'></i>
							<span class="text nav-text">
								<?php esc_html_e( 'Instruction', 'tecslider' ); ?>
							</span>
						</a>
					</li>
				</ul>
			</div>
			<div class="bottom-content">
				<li class="mode">
					<div class="moon-sun">
						<i class="bx bx-moon icon moon"></i>
						<i class="bx bx-sun icon sun"></i>
					</div>
					<span class="mode-text text">
						<?php
						if ( 'light' === $mode_ ) {
							esc_html_e( 'Light Mode', 'tecslider' );
						} else {
							esc_html_e( 'Dark Mode', 'tecslider' );
						}
						?>
					</span>
					<div class="toggle-switch">
						<span class="switch"></span>
					</div>
				</li>
				<li class="">
					<a href="#">
						<i class="bx bx-at icon"></i>
						<span class="text nav-text">
							<?php esc_html_e( 'Version', 'tecslider' ); ?> <?php echo esc_html( $tecslider->version ); ?>
						</span>
					</a>
				</li>
			</div>
		</div>
	</nav>
	<section class="main">
		<div class="mywptrek-admin-page-content active mwt-be-form" id="settings">
			<form method="post" action="options.php" id="momo-momoacg-admin-settings-form">
				<?php settings_fields( 'mwt-tecslider-settings-general-group' ); ?>
				<?php do_settings_sections( 'mwt-tecslider-settings-general-group' ); ?>
				<?php require_once 'page-admin-settings.php'; ?>
				<?php submit_button(); ?>
			</form>
		</div>
		<div class="mywptrek-admin-page-content mwt-be-form" id="shortcode">
			<?php require_once 'page-admin-shortcode.php'; ?>
		</div>
		<?php do_action( 'tecslider_admin_menu_content' ); ?>
		<div class="mywptrek-admin-page-content mwt-be-form" id="instructions">
			<?php require_once 'page-admin-instructions.php'; ?>
		</div>
	</section>
</div>
