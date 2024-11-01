<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Elementor oEmbed Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Tecslider_Elementor_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve oEmbed widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'tecslider-elementor-widget';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve oEmbed widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Event Slider', 'elementor-oembed-widget' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve oEmbed widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-eventglide';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'general' );
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the oEmbed widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return array( 'slider', 'calendar', 'events', 'tecslider', 'glide' );
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Register oEmbed widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		global $tecslider;
		$is_premium = tsa_fs()->is_premium();
		$this->start_controls_section(
			'tecslider_content_section',
			array(
				'label' => esc_html__( 'EventGlide', 'tecslider' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$premium_text = ! $is_premium ? esc_html__( ' (Premium)', 'tecslider' ) : '';
		$disabled     = ! $is_premium ? '_disabled' : '';

		$this->add_control(
			'sliderType',
			array(
				'label'       => esc_html__( 'Event type', 'textdomain' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'upcoming',
				'label_block' => true,
				'options'     => array(
					'upcoming'           => esc_html__( 'Upcoming', 'tecslider' ),
					'past'               => esc_html__( 'Past', 'tecslider' ),
					'custom' . $disabled => esc_html__( 'Custom', 'tecslider' ) . $premium_text,
				),
				'selectors'   => array(),
			)
		);

		$premium_options = array(
			'imagemiddle' . $disabled => esc_html__( 'Image Middle', 'tecslider' ) . $premium_text,
			'overimage' . $disabled   => esc_html__( 'Over Image', 'tecslider' ) . $premium_text,
			'hoverdetail' . $disabled => esc_html__( 'Hover Detail', 'tecslider' ) . $premium_text,
			'hoverflip' . $disabled   => esc_html__( 'Flip on Hover', 'tecslider' ) . $premium_text,
		);

		$options_to_show = $premium_options;
		$all_options     = array(
			'datetop'     => esc_html__( 'Date Top', 'tecslider' ),
			'coloredcard' => esc_html__( 'Colored Card', 'tecslider' ),
			'singleevent' => esc_html__( 'Single Event', 'tecslider' ),
			...$options_to_show,
		);
		$this->add_control(
			'sliderTheme',
			array(
				'label'       => esc_html__( 'Select Theme', 'textdomain' ),
				'type'        => \Elementor\Controls_Manager::SELECT,
				'default'     => 'datetop',
				'options'     => $all_options,
				'label_block' => true,
				'selectors'   => array(),
			)
		);

		$this->add_control(
			'eventInRow',
			array(
				'label'     => esc_html__( 'Event count', 'textdomain' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'1' => esc_html__( '1', 'tecslider' ),
					'2' => esc_html__( '2', 'tecslider' ),
					'3' => esc_html__( '3', 'tecslider' ),
					'4' => esc_html__( '3', 'tecslider' ),
				),
				'selectors' => array(),
			)
		);
		$this->add_control(
			'eventInSlide',
			array(
				'label'     => esc_html__( 'Event(s) on Slide', 'textdomain' ),
				'type'      => \Elementor\Controls_Manager::SELECT,
				'default'   => '3',
				'options'   => array(
					'1' => esc_html__( '1', 'tecslider' ),
					'2' => esc_html__( '2', 'tecslider' ),
					'3' => esc_html__( '3', 'tecslider' ),
					'4' => esc_html__( '4', 'tecslider' ),
				),
				'selectors' => array(),
			)
		);
		$label        = esc_html__( 'Enable Countdown Timer', 'textdomain' );
		$premium_sign = '';
		$id           = 'countdownTimer';
		if ( ! $is_premium ) {
			$premium_sign = '<span class="mwt-premium-badge">' . esc_html__( 'Premium', 'tecslider' ) . '</span>';
			$id           = 'countdownTimer_disabled';
		}
		$this->add_control(
			$id,
			array(
				'label'        => $label . $premium_sign,
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'default'      => 'off',
				'label_block'  => true,
			)
		);
		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Auto start and slide', 'tecslider' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'default'      => 'off',
				'label_block'  => false,
			)
		);

		$label        = esc_html__( 'Enable Dots', 'textdomain' );
		$premium_sign = '';
		$id           = 'dots';
		if ( ! $is_premium ) {
			$premium_sign = '<span class="mwt-premium-badge">' . esc_html__( 'Premium', 'tecslider' ) . '</span>';
			$id           = 'dots_disabled';
		}
		$this->add_control(
			$id,
			array(
				'label'        => $label . $premium_sign,
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'default'      => 'off',
				'label_block'  => false,
			)
		);
		$this->add_control(
			'newtab',
			array(
				'label'        => esc_html__( 'Open event in new tab', 'tecslider' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'default'      => 'off',
				'label_block'  => false,
			)
		);

		$label        = esc_html__( 'Enable Dark Mode', 'textdomain' );
		$premium_sign = '';
		$id           = 'darkmode';
		if ( ! $is_premium ) {
			$premium_sign = '<span class="mwt-premium-badge">' . esc_html__( 'Premium', 'tecslider' ) . '</span>';
			$id           = 'darkmode_disabled';
		}
		$this->add_control(
			$id,
			array(
				'label'        => $label . $premium_sign,
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'return_value' => 'on',
				'default'      => 'off',
				'label_block'  => true,
			)
		);

		$categories = $tecslider->function->tecslider_get_tribe_event_categories();
		$this->add_control(
			'category',
			array(
				'label'       => esc_html__( 'Event Categories', 'tecslider' ),
				'type'        => \Elementor\Controls_Manager::SELECT2,
				'options'     => array_column( $categories, 'text', 'id' ),
				'multiple'    => true,
				'description' => esc_html__( 'Select event categories.', 'tecslider' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'transitionDelay',
			array(
				'label'   => esc_html__( 'Transition Delay (in ms.)', 'tecslider' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => '400',
				'options' => array(
					'200'  => esc_html__( '200', 'tecslider' ),
					'400'  => esc_html__( '400', 'tecslider' ),
					'600'  => esc_html__( '600', 'tecslider' ),
					'800'  => esc_html__( '800', 'tecslider' ),
					'1000' => esc_html__( '1000', 'tecslider' ),
				),
			)
		);

		$this->add_control(
			'slideHeight',
			array(
				'label'      => esc_html__( 'Slider detail Height', 'tecslider' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 100,
						'max'  => 600,
						'step' => 10,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 300,
				),
			)
		);

		$this->add_control(
			'imageHeight',
			array(
				'label'      => esc_html__( 'Image Height', 'tecslider' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'custom' ),
				'range'      => array(
					'px' => array(
						'min'  => 100,
						'max'  => 600,
						'step' => 10,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 300,
				),
			)
		);

		$this->add_control(
			'colorScheme',
			array(
				'label'   => esc_html__( 'Slider Color', 'textdomain' ),
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => '#5a30f3',
			)
		);
		if ( class_exists( 'Tribe__Tickets__Tickets' ) ) {
			$this->add_control(
				'ticketInfo',
				array(
					'label'        => esc_html__( 'Ticket Info', 'tecslider' ),
					'type'         => \Elementor\Controls_Manager::SWITCHER,
					'return_value' => 'on',
					'default'      => 'off',
					'label_block'  => false,
				)
			);
		}
		$this->end_controls_section();

	}

	/**
	 * Render oEmbed widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		global $tecslider;
		$settings['slideHeight'] = $settings['slideHeight']['size'];
		$settings['imageHeight'] = $settings['imageHeight']['size'];
		$settings['ticketInfo']  = 'on' === $settings['ticketInfo'] ? true : false;
		$settings['dots']        = 'on' === $settings['dots'] ? true : false;
		$settings['newtab']      = 'on' === $settings['newtab'] ? true : false;
		$settings['darkmode']    = 'on' === $settings['darkmode'] ? true : false;

		$settings['countdownTimer'] = 'on' === $settings['countdownTimer'] ? true : false;
		?>
		<div class="oembed-elementor-widget">
			<?php echo $tecslider->blocks->render_block_core_archives_tecsb( $settings ); //phpcs:ignore ?>
		</div>
		<?php
	}
	/**
	 * Get widget scripts.
	 */
	public function get_script_depends() {
		return array( 'tecslider-script' );
	}
	/**
	 * Get widget styles.
	 */
	public function get_style_depends() {
		return array( 'tecslider-styles', 'tecslider-tmeme-styles', 'tecslider-block-styles' );
	}

}
