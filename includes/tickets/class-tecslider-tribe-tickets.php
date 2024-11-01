<?php
/**
 * Event Tickets Class for Slider Addons
 *
 * @author   mywptrek
 * @since  2.2.0
 * @package  tecslider
 */
class Tecslider_Tribe_Tickets {
	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'tecslider_admin_menu', array( $this, 'tecslider_admin_menu' ) );
		add_action( 'tecslider_admin_menu_content', array( $this, 'tecslider_admin_menu_content' ) );
	}
	/**
	 * Admin Menu
	 */
	public function tecslider_admin_menu() {
		?>
		<li class="nav-link">
			<a href="#ticket">
				<i class='bx bx-receipt icon'></i>
				<span class="text nav-text">
					<?php esc_html_e( 'Ticket', 'tecslider' ); ?>
				</span>
			</a>
		</li>
		<?php
	}
	/**
	 * Admin Menu Content
	 */
	public function tecslider_admin_menu_content() {
		?>
		<div class="mywptrek-admin-page-content mwt-be-form" id="instructions">
		<?php
		include_once 'pages/page-tecslider-admin-ticket.php';
		?>
		</div>
		<?php
	}
}
