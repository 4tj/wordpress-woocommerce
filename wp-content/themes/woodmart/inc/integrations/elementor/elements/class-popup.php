<?php
/**
 * Popup map.
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
class Popup extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_popup';
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
		return esc_html__( 'Popup', 'woodmart' );
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
		return 'wd-icon-popup';
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
			'popup_id',
			[
				'label'   => esc_html__( 'ID', 'woodmart' ),
				'type'    => Controls_Manager::TEXT,
				'default' => 'popup-' . uniqid(),
			]
		);

		$this->add_control(
			'content',
			[
				'label'       => esc_html__( 'Content', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => woodmart_get_elementor_html_blocks_array(),
				'description' => function_exists( 'woodmart_get_html_block_links' ) ? woodmart_get_html_block_links() : '',
				'default'     => '0',
			]
		);

		$this->end_controls_section();

		/**
		 * Button settings.
		 */
		$this->start_controls_section(
			'button_content_section',
			[
				'label' => esc_html__( 'Button', 'woodmart' ),
			]
		);

		woodmart_get_button_content_general_map(
			$this,
			[
				'link'                => false,
				'smooth_scroll'       => false,
				'collapsible_content' => false,
			]
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
			'width',
			[
				'label'   => esc_html__( 'Width', 'woodmart' ),
				'type'    => Controls_Manager::SLIDER,
				'default' => [
					'size' => 800,
				],
				'range'   => [
					'px' => [
						'min'  => 150,
						'max'  => 2000,
						'step' => 10,
					],
				],
			]
		);

		$this->add_control(
			'padding',
			array(
				'label'      => esc_html__( 'Padding', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 200,
						'step' => 1,
					),
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Button settings.
		 */
		$this->start_controls_section(
			'button_style_section',
			[
				'label' => esc_html__( 'Button', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		woodmart_get_button_style_general_map( $this );
		woodmart_get_button_style_layout_map( $this );
		woodmart_get_button_style_icon_map( $this );

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
			'popup_id' => 'my_popup',
			'content'  => '',
			'link'     => array(),
			'width'    => 800,
		];

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		$inline_styles_settings = array(
			'--wd-popup-width' => $settings['width']['size'] . 'px',
		);

		if ( ! empty( $settings['padding']['size'] ) || 0 == $settings['padding']['size'] ) { //phpcs:ignore
			$inline_styles_settings['padding'] = $settings['padding']['size'] . $settings['padding']['unit'];
		}

		$inline_styles = '';

		foreach ( $inline_styles_settings as $prop => $val ) {
			$inline_styles .= $prop . ':' . $val . ';';
		}

		$settings['link']['url']    = '#' . esc_attr( $settings['popup_id'] );
		$settings['custom_classes'] = 'wd-open-popup';

		woodmart_enqueue_js_library( 'magnific' );
		woodmart_enqueue_js_script( 'popup-element' );
		woodmart_enqueue_inline_style( 'mfp-popup' );

		?>
		<?php woodmart_elementor_button_template( $settings ); ?>
		<?php if ( $settings['content'] ) : ?>
			<div id="<?php echo esc_attr( $settings['popup_id'] ); ?>" class="wd-popup wd-popup-element wd-entry-content mfp-hide<?php echo woodmart_get_old_classes( ' woodmart-content-popup' ); ?>" style="<?php echo esc_attr( $inline_styles ); ?>">
				<?php echo woodmart_get_html_block( $settings['content'], true ); // phpcs:ignore ?>
			</div>
		<?php endif; ?>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Popup() );
