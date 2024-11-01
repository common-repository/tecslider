<?php

/**
 * Plugin Name: Slider Addons for The Events Calendar
 * Plugin URI: http://tecsb.mywptrek.com
 * Description: Slider display for your events.
 * Author: MyWpTrek
 * Text Domain: tecslider
 * Domain Path: /languages
 * Version: 2.3.0
 * Author URI: http://www.mywptrek.com/profile
 * Requires at least: 5.6
 * Tested up to: 6.5
 *
 * Requires Plugins: the-events-calendar
 */
/**
 * Freemius Integration
 */
if ( !function_exists( 'tsa_fs' ) ) {
    /**
     * Create a helper function for easy SDK access.
     */
    function tsa_fs() {
        global $tsa_fs;
        if ( !isset( $tsa_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $tsa_fs = fs_dynamic_init( array(
                'id'             => '9773',
                'slug'           => 'tecslider',
                'premium_slug'   => 'eventglidepro',
                'type'           => 'plugin',
                'public_key'     => 'pk_c520c9c7f7d11b71ef8a2976c632a',
                'is_premium'     => false,
                'premium_suffix' => 'Premium',
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => array(
                    'slug' => 'tecslider',
                ),
                'is_live'        => true,
            ) );
        }
        return $tsa_fs;
    }

    // Init Freemius.
    tsa_fs();
    // Signal that SDK was initiated.
    do_action( 'tsa_fs_loaded' );
}
/**
 * Plugin Main Class
 */
class MWT_Tec_Slider {
    /**
     * Plugin Version
     *
     * @var string
     */
    public $version = '2.3.0';

    /**
     * Event Calendar Version
     *
     * @var string
     */
    public $tec_version = '6.2.8.2';

    /**
     * Plugin Name
     *
     * @var string
     */
    public $name = 'Slider Addons for The Events Calendar';

    /**
     * Plugin Slug
     *
     * @var string
     */
    public $slug = 'tecslider';

    /**
     * Plugin URL
     *
     * @var string
     */
    public $plugin_url;

    /**
     * Plugin URL
     *
     * @var string
     */
    public $plugin_slug;

    /**
     * Plugin URL
     *
     * @var string
     */
    public $plugin_path;

    /**
     * Plugin URL
     *
     * @var string
     */
    public $blocks_path;

    /**
     * Plugin URL
     *
     * @var string
     */
    public $tecslider_url;

    /**
     * Plugin URL
     *
     * @var string
     */
    public $tecslider_path;

    /**
     * Plugin URL
     *
     * @var string
     */
    public $tecslider_assets;

    /**
     * Plugin URL
     *
     * @var array
     */
    public $options;

    /**
     * Plugin URL
     *
     * @var Tecslider_Function
     */
    public $function;

    /**
     * Plugin URL
     *
     * @var Tecslider_Blocks
     */
    public $blocks;

    /**
     * Plugin URL
     *
     * @var Tecslider_Admin_Init
     */
    public $admin;

    /**
     * Tickets
     *
     * @var Tecslider_Tribe_Tickets
     */
    public $tec_tribe_tickets;

    /**
     * Constructor
     */
    public function __construct() {
        $this->super_init();
        $this->options = get_option( 'tecslider-options' );
        add_action( 'plugins_loaded', array($this, 'plugin_init') );
    }

    /**
     * Super Initialization
     */
    public function super_init() {
        $this->plugin_url = path_join( WP_PLUGIN_URL, basename( dirname( __FILE__ ) ) );
        $this->plugin_slug = plugin_basename( __FILE__ );
        $this->plugin_path = dirname( __FILE__ );
        $this->blocks_path = $this->plugin_url . '/includes/blocks';
        $this->tecslider_url = path_join( plugins_url(), basename( dirname( __FILE__ ) ) );
        $this->tecslider_path = dirname( __FILE__ );
        $this->tecslider_assets = str_replace( array('http:', 'https:'), '', $this->tecslider_url ) . '/assets/';
    }

    /**
     * Plugin Initialization
     */
    public function plugin_init() {
        include_once $this->plugin_path . '/includes/class-tecslider-function.php';
        include_once $this->plugin_path . '/includes/class-tecslider-rest-api.php';
        include_once $this->plugin_path . '/includes/blocks/class-tecslider-blocks.php';
        include_once $this->plugin_path . '/includes/blocks/class-tecslider-blocks-init.php';
        include_once $this->plugin_path . '/includes/class-tecslider-shortcodes.php';
        $this->function = new Tecslider_Function();
        $this->blocks = new Tecslider_Blocks();
        if ( is_admin() ) {
            include_once $this->plugin_path . '/includes/admin/class-tecslider-admin-init.php';
            include_once $this->plugin_path . '/includes/admin/class-tecslider-settings-ajax.php';
            $this->admin = new Tecslider_Admin_Init();
        }
        if ( class_exists( 'Tribe__Tickets__Tickets' ) ) {
            include_once $this->plugin_path . '/includes/tickets/class-tecslider-tribe-tickets.php';
            /* $this->tec_tribe_tickets = new Tecslider_Tribe_Tickets(); */
        }
        /** Elementor */
        if ( $this->tecslider_is_elementor_active() ) {
            include_once $this->plugin_path . '/elementor-addon/class-tecslider-elementor-addons.php';
        }
    }

    /**
     * Check if Elementor is active
     */
    public function tecslider_is_elementor_active() {
        return defined( 'ELEMENTOR_VERSION' );
    }

}

$GLOBALS['tecslider'] = new MWT_Tec_Slider();