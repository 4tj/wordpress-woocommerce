<?php
/**
 * Countdown timer map.
 */

namespace XTS\Elementor;

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Countdown extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_countdown_timer';
	}

	/**
	 * Get widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Countdown timer', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-countdown';
	}

	/**
	 * Get widget categories.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'wd-elements' ];
	}

	/**
	 * Register the widget controls.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {
		/**
		 * Content tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_content_section',
			[
				'label' => esc_html__( 'General', 'woodmart' ),
			]
		);

		$this->add_control(
			'date',
			[
				'label'   => esc_html__( 'Date', 'woodmart' ),
				'type'    => Controls_Manager::DATE_TIME,
				'default' => date( 'Y-m-d', strtotime( ' +2 months' ) ),
			]
		);

		$this->add_control(
			'hide_on_finish',
			array(
				'label'        => esc_html__( 'Hide countdown on finish', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'no',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => 'yes',
			)
		);

		$this->end_controls_section();

		/**
		 * Style tab.
		 */

		/**
		 * General settings.
		 */
		$this->start_controls_section(
			'general_style_section',
			[
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'style',
			[
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'simple'      => esc_html__( 'Default', 'woodmart' ),
					'standard'    => esc_html__( 'Shadow', 'woodmart' ),
					'transparent' => esc_html__( 'Transparent', 'woodmart' ),
					'active'      => esc_html__( 'Primary color', 'woodmart' ),
				],
				'default' => 'standard',
			]
		);

		$this->add_control(
			'woodmart_color_scheme',
			[
				'label'   => esc_html__( 'Color Scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				],
				'default' => '',
			]
		);

		$this->add_control(
			'align',
			[
				'label'   => esc_html__( 'Align', 'woodmart' ),
				'type'    => 'wd_buttons',
				'options' => [
					'left'   => [
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
					],
					'right'  => [
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					],
				],
				'default' => 'center',
			]
		);

		$this->add_control(
			'size',
			[
				'label'   => esc_html__( 'Predefined size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => [
					'small'  => esc_html__( 'Small (20px)', 'woodmart' ),
					'medium' => esc_html__( 'Medium (24px)', 'woodmart' ),
					'large'  => esc_html__( 'Large (28px)', 'woodmart' ),
					'xlarge' => esc_html__( 'Extra Large (42px)', 'woodmart' ),
				],
				'default' => 'medium',
			]
		);
		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 *
	 * @access protected
	 */
	protected function render() {
		$default_settings = [
			'date'                  => '2020-12-12',
			'woodmart_color_scheme' => 'dark',
			'size'                  => 'medium',
			'align'                 => 'center',
			'style'                 => 'standard',
			'hide_on_finish'        => 'no',
		];

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		$timezone = apply_filters( 'woodmart_wp_timezone_element', false ) ? get_option( 'timezone_string' ) : 'GMT';

		$this->add_render_attribute(
			[
				'wrapper' => [
					'class' => [
						'wd-countdown-timer',
						'color-scheme-' . $settings['woodmart_color_scheme'],
						'text-' . $settings['align'],
					],
				],
				'timer'   => [
					'class'         => [
						'wd-timer',
						'wd-size-' . $settings['size'],
						'wd-style-' . $settings['style'],
						woodmart_get_old_classes( ' woodmart-timer' ),
					],
					'data-end-date' => [
						apply_filters( 'wd_countdown_timer_end_date', $settings['date'] ),
					],
					'data-timezone' => [
						$timezone,
					],
					'data-hide-on-finish' => [
						$settings['hide_on_finish'],
					],
				],
			]
		);

		woodmart_enqueue_js_library( 'countdown-bundle' );
		woodmart_enqueue_js_script( 'countdown-element' );
		woodmart_enqueue_inline_style( 'countdown' );

		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<div <?php echo $this->get_render_attribute_string( 'timer' ); ?>>
				<span class="wd-timer-days">
					<span class="wd-timer-value">
						0
					</span>
					<span class="wd-timer-text">
						<?php esc_html_e( 'days', 'woodmart' ); ?>
					</span>
				</span>
				<span class="wd-timer-hours">
					<span class="wd-timer-value">
						00
					</span>
					<span class="wd-timer-text">
						<?php esc_html_e( 'hr', 'woodmart' ); ?>
					</span>
				</span>
				<span class="wd-timer-min">
					<span class="wd-timer-value">
						00
					</span>
					<span class="wd-timer-text">
						<?php esc_html_e( 'min', 'woodmart' ); ?>
					</span>
				</span>
				<span class="wd-timer-sec">
					<span class="wd-timer-value">
						00
					</span>
					<span class="wd-timer-text">
						<?php esc_html_e( 'sc', 'woodmart' ); ?>
					</span>
				</span>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Countdown() );
