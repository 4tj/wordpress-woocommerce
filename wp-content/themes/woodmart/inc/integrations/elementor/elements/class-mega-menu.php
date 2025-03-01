<?php
/**
 * Mega menu map.
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use XTS\Modules\Mega_Menu_Walker;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class WD_Mega_Menu extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_mega_menu';
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
		return esc_html__( 'Mega Menu widget', 'woodmart' );
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
		return 'wd-icon-mega-menu';
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
		return array( 'wd-elements' );
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
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
			)
		);

		$this->add_control(
			'title',
			array(
				'label'     => esc_html__( 'Title', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'condition' => array(
					'design' => array( 'vertical' ),
				),
				'default'   => 'Title text example',
			)
		);

		$this->add_control(
			'nav_menu',
			array(
				'label'   => esc_html__( 'Choose Menu', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => woodmart_get_menus_array( 'elementor' ),
				'default' => '',
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
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'design',
			array(
				'label'   => esc_html__( 'Orientation', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'vertical'   => esc_html__( 'Vertical', 'woodmart' ),
					'horizontal' => esc_html__( 'Horizontal', 'woodmart' ),
				),
				'default' => 'vertical',
			)
		);

		$this->add_control(
			'dropdown_design',
			array(
				'label'     => esc_html__( 'Design', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'default' => esc_html__( 'Default', 'woodmart' ),
					'with-bg' => esc_html__( 'With background', 'woodmart' ),
					'simple'  => esc_html__( 'Simple', 'woodmart' ),
				),
				'condition' => array(
					'design' => array( 'vertical' ),
				),
				'default'   => 'default',
			)
		);

		$this->add_control(
			'vertical_items_gap',
			array(
				'label'     => esc_html__( 'Items gap', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					's' => esc_html__( 'Small', 'woodmart' ),
					'm' => esc_html__( 'Medium', 'woodmart' ),
					'l' => esc_html__( 'Large', 'woodmart' ),
				),
				'condition' => array(
					'design'          => array( 'vertical' ),
					'dropdown_design' => array( 'simple' ),
				),
				'default'   => 's',
			)
		);

		$this->add_control(
			'style',
			array(
				'label'     => esc_html__( 'Style', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'default'   => esc_html__( 'Default', 'woodmart' ),
					'underline' => esc_html__( 'Underline', 'woodmart' ),
					'bordered'  => esc_html__( 'Bordered', 'woodmart' ),
					'separated' => esc_html__( 'Separated', 'woodmart' ),
					'bg'        => esc_html__( 'Background', 'woodmart' ),
				),
				'condition' => array(
					'design' => array( 'horizontal' ),
				),
				'default'   => 'default',
			)
		);

		$this->add_control(
			'items_gap',
			array(
				'label'     => esc_html__( 'Items gap', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					's' => esc_html__( 'Small', 'woodmart' ),
					'm' => esc_html__( 'Medium', 'woodmart' ),
					'l' => esc_html__( 'Large', 'woodmart' ),
				),
				'condition' => array(
					'design' => array( 'horizontal' ),
				),
				'default'   => 's',
			)
		);

		$this->add_control(
			'alignment',
			array(
				'label'     => esc_html__( 'Alignment', 'woodmart' ),
				'type'      => 'wd_buttons',
				'options'   => array(
					'left'   => array(
						'title' => esc_html__( 'Left', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
					),
					'center' => array(
						'title' => esc_html__( 'Center', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
					),
					'right'  => array(
						'title' => esc_html__( 'Right', 'woodmart' ),
						'image' => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
				),
				'condition' => array(
					'design' => array( 'horizontal' ),
				),
				'default'   => 'left',
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'item_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .wd-nav > .menu-item > a',
			)
		);

		$this->end_controls_section();

		/**
		 * Title options.
		 */
		$this->start_controls_section(
			'title_style_section',
			array(
				'label'     => esc_html__( 'Title options', 'woodmart' ),
				'tab'       => Controls_Manager::TAB_STYLE,
				'condition' => array(
					'design' => array( 'vertical' ),
				),
			)
		);

		$this->add_control(
			'woodmart_color_scheme',
			array(
				'label'   => esc_html__( 'Color Scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				),
				'default' => '',
			)
		);

		$this->add_control(
			'color',
			array(
				'label'     => esc_html__( 'Title background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .widget-title' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Icon options.
		 */
		$this->start_controls_section(
			'icon_style_section',
			array(
				'label' => esc_html__( 'Icon options', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'icon_alignment',
			array(
				'label'   => esc_html__( 'Alignment', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Default', 'woodmart' ),
					'left'    => esc_html__( 'Left', 'woodmart' ),
					'right'   => esc_html__( 'Right', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->add_responsive_control(
			'icon_height',
			array(
				'label'      => esc_html__( 'Height', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wd-menu > ul > li > a .wd-nav-img' => '--nav-img-height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'icon_width',
			array(
				'label'      => esc_html__( 'Width', 'woodmart' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 50,
						'step' => 1,
					),
				),
				'selectors'  => array(
					'{{WRAPPER}} .wd-menu > ul > li > a .wd-nav-img' => '--nav-img-width: {{SIZE}}{{UNIT}};',
				),
			)
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
		$default_settings = array(
			'title'                 => '',
			'alignment'             => 'left',
			'nav_menu'              => '',
			'style'                 => 'default',
			'design'                => 'vertical',
			'dropdown_design'       => 'default',
			'items_gap'             => 's',
			'vertical_items_gap'    => 's',
			'icon_alignment'        => 'inherit',
			'color'                 => '',
			'woodmart_color_scheme' => 'light',
		);

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		$this->add_render_attribute(
			array(
				'title' => array(
					'class' => array(
						'widget-title',
						'color-scheme-' . $settings['woodmart_color_scheme'],
					),
				),
			)
		);

		$menu_class = 'menu wd-nav';

		if ( ! empty( $settings['design'] ) ) {
			$menu_class .= ' wd-nav-' . $settings['design'];
			woodmart_get_old_classes( $settings['design'] . '-navigation' );
		}

		if ( ! empty( $settings['style'] ) ) {
			$menu_class .= ' wd-style-' . $settings['style'];
			woodmart_get_old_classes( 'navigation-style-' . $settings['style'] );
		}

		$wrapper_classes = '';
		if ( 'horizontal' === $settings['design'] ) {
			$wrapper_classes .= ' text-' . $settings['alignment'];
			$menu_class      .= ' wd-gap-' . $settings['items_gap'];
		}

		if ( 'vertical' === $settings['design'] ) {
			$menu_class .= ' wd-design-' . $settings['dropdown_design'];
			$menu_class .= ' wd-gap-' . $settings['vertical_items_gap'];

			woodmart_enqueue_inline_style( 'mod-nav-vertical' );
			woodmart_enqueue_inline_style( 'mod-nav-vertical-design-' . $settings['dropdown_design'] );
		}

		if ( $settings['icon_alignment'] && 'inherit' !== $settings['icon_alignment'] ) {
			$menu_class .= ' wd-icon-' . $settings['icon_alignment'];
		}

		woodmart_enqueue_inline_style( 'el-menu' );
		woodmart_enqueue_inline_style( 'el-menu-wpb-elem' );

		$this->add_inline_editing_attributes( 'title' );

		?>
		<div class="wd-menu widget_nav_mega_menu<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php if ( $settings['title'] ) : ?>
				<h5 <?php echo $this->get_render_attribute_string( 'title' ); // phpcs:ignore ?>>
					<?php echo wp_kses( $settings['title'], woodmart_get_allowed_html() ); ?>
				</h5>
			<?php endif; ?>
			<?php
			wp_nav_menu(
				array(
					'container'   => '',
					'fallback_cb' => '',
					'menu'        => $settings['nav_menu'],
					'menu_class'  => $menu_class,
					'walker'      => new Mega_Menu_Walker(),
				)
			);
			?>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new WD_Mega_Menu() );
