<?php
/**
 * Products element.
 *
 * @package Woodmart
 */

namespace XTS\Modules\Layouts;

use Elementor\Controls_Manager;
use Elementor\Plugin;
use Elementor\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 */
class Archive_Products extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_archive_products';
	}

	/**
	 * Get widget content.
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Archive products', 'woodmart' );
	}

	/**
	 * Get widget icon.
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'wd-icon-sa-archive-products';
	}

	/**
	 * Get widget categories.
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return array( 'wd-shop-archive-elements' );
	}

	/**
	 * Show in panel.
	 *
	 * @return bool Whether to show the widget in the panel or not.
	 */
	public function show_in_panel() {
		return Main::is_layout_type( 'shop_archive' );
	}

	/**
	 * Register the widget controls.
	 */
	protected function register_controls() {
		/**
		 * Content tab
		 */

		/**
		 * General settings
		 */
		$this->start_controls_section(
			'general_style_section',
			array(
				'label' => esc_html__( 'General', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-shop-product',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'wrapper_css_classes',
			array(
				'type'         => 'wd_css_class',
				'default'      => 'wd-products-element',
				'prefix_class' => '',
			)
		);

		$this->add_control(
			'products_view',
			array(
				'label'   => esc_html__( 'Products view', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'grid'    => esc_html__( 'Grid', 'woodmart' ),
					'list'    => esc_html__( 'List', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->add_control(
			'product_hover',
			array(
				'label'     => esc_html__( 'Hover on product', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inherit'          => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'info-alt'         => esc_html__( 'Full info on hover', 'woodmart' ),
					'info'             => esc_html__( 'Full info on image', 'woodmart' ),
					'alt'              => esc_html__( 'Icons and "add to cart" on hover', 'woodmart' ),
					'icons'            => esc_html__( 'Icons on hover', 'woodmart' ),
					'quick'            => esc_html__( 'Quick', 'woodmart' ),
					'button'           => esc_html__( 'Show button on hover on image', 'woodmart' ),
					'base'             => esc_html__( 'Show summary on hover', 'woodmart' ),
					'standard'         => esc_html__( 'Standard button', 'woodmart' ),
					'tiled'            => esc_html__( 'Tiled', 'woodmart' ),
					'fw-button'        => esc_html__( 'Full width button', 'woodmart' ),
					'buttons-on-hover' => esc_html__( 'Buttons on hover', 'woodmart' ),
				),
				'default'   => 'inherit',
				'condition' => array(
					'products_view!' => array( 'list' ),
				),
			)
		);

		$this->add_responsive_control(
			'products_columns',
			array(
				'label'          => esc_html__( 'Products columns', 'woodmart' ),
				'type'           => Controls_Manager::SELECT,
				'options'        => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'1'       => esc_html__( '1', 'woodmart' ),
					'2'       => esc_html__( '2', 'woodmart' ),
					'3'       => esc_html__( '3', 'woodmart' ),
					'4'       => esc_html__( '4', 'woodmart' ),
					'5'       => esc_html__( '5', 'woodmart' ),
					'6'       => esc_html__( '6', 'woodmart' ),
				),
				'default'        => 'inherit',
				'tablet_default' => 'inherit',
				'mobile_default' => 'inherit',
				'render_type'    => 'template',
				'devices'        => array( 'desktop', 'tablet', 'mobile' ),
				'classes'        => 'wd-hide-custom-breakpoints',
			)
		);

		$this->add_responsive_control(
			'products_spacing',
			array(
				'label'   => esc_html__( 'Space between products', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'0'       => esc_html__( '0', 'woodmart' ),
					'2'       => esc_html__( '2', 'woodmart' ),
					'6'       => esc_html__( '6', 'woodmart' ),
					'10'      => esc_html__( '10', 'woodmart' ),
					'20'      => esc_html__( '20', 'woodmart' ),
					'30'      => esc_html__( '30', 'woodmart' ),
				),
				'default' => 'inherit',
				'devices' => array( 'desktop', 'tablet', 'mobile' ),
				'classes' => 'wd-hide-custom-breakpoints',
			)
		);

		$this->add_control(
			'shop_pagination',
			array(
				'label'   => esc_html__( 'Products pagination', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit'    => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'pagination' => esc_html__( 'Pagination', 'woodmart' ),
					'more-btn'   => esc_html__( '"Load more" button', 'woodmart' ),
					'infinit'    => esc_html__( 'Infinite scrolling', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->add_control(
			'img_size',
			array(
				'label'   => esc_html__( 'Image size', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'default' => 'large',
				'options' => woodmart_get_all_image_sizes_names( 'elementor' ),
			)
		);

		$this->add_control(
			'img_size_custom',
			array(
				'label'       => esc_html__( 'Image dimension', 'woodmart' ),
				'type'        => Controls_Manager::IMAGE_DIMENSIONS,
				'description' => esc_html__( 'You can crop the original image size to any custom size. You can also set a single value for height or width in order to keep the original size ratio.', 'woodmart' ),
				'condition'   => array(
					'img_size' => 'custom',
				),
			)
		);

		$this->end_controls_section();

		/**
		 * Products design settings.
		 */
		$this->start_controls_section(
			'products_design_style_section',
			array(
				'label' => esc_html__( 'Products design', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'products_color_scheme',
			array(
				'label'        => esc_html__( 'Products color scheme', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'default'      => 'inherit',
				'options'      => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'default' => esc_html__( 'Default', 'woodmart' ),
					'dark'    => esc_html__( 'Dark', 'woodmart' ),
					'light'   => esc_html__( 'Light', 'woodmart' ),
				),
			)
		);

		$this->add_control(
			'products_bordered_grid',
			array(
				'label'       => esc_html__( 'Products border', 'woodmart' ),
				'description' => esc_html__( 'Add borders between the products in your grid', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'enable'  => esc_html__( 'Enable', 'woodmart' ),
					'disable' => esc_html__( 'Disable', 'woodmart' ),
				),
				'default' => 'inherit',
			)
		);

		$this->add_control(
			'products_bordered_grid_style',
			array(
				'label'     => esc_html__( 'Border position', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'outside' => esc_html__( 'Outside', 'woodmart' ),
					'inside'  => esc_html__( 'Inside', 'woodmart' ),
				),
				'condition' => array(
					'products_bordered_grid' => array( 'enable' ),
				),
				'default'   => 'inherit',
			)
		);

		$this->add_control(
			'products_border_color',
			array(
				'label'     => esc_html__( 'Custom border color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} [class*="products-bordered-grid"], {{WRAPPER}} [class*="products-bordered-grid"] .wd-product' => '--wd-bordered-brd:{{VALUE}};',
				),
				'condition' => array(
					'products_bordered_grid' => array( 'enable' ),
				),
			)
		);

		$this->add_control(
			'products_with_background',
			array(
				'label'       => esc_html__( 'Products background', 'woodmart' ),
				'description' => esc_html__( 'Add a background to the products in your grid.', 'woodmart' ),
				'type'        => Controls_Manager::SELECT,
				'options'     => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'yes'     => esc_html__( 'Yes', 'woodmart' ),
					'no'      => esc_html__( 'No', 'woodmart' ),
				),
				'default'     => 'inherit',
			)
		);

		$this->add_control(
			'products_background',
			array(
				'label'     => esc_html__( 'Custom background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-products-with-bg, {{WRAPPER}} .wd-products-with-bg :is(.wd-product,.wd-cat)' => '--wd-prod-bg:{{VALUE}}; --wd-bordered-bg:{{VALUE}};',
				),
				'condition' => array(
					'products_with_background' => array( 'yes' ),
				),
			)
		);

		$this->add_control(
			'products_shadow',
			array(
				'label'        => esc_html__( 'Products shadow', 'woodmart' ),
				'description'  => esc_html__( 'Add a shadow to products if the initial product style did not have one.', 'woodmart' ),
				'type'         => Controls_Manager::SELECT,
				'options'      => array(
					'inherit' => esc_html__( 'Inherit from Theme Settings', 'woodmart' ),
					'yes'     => esc_html__( 'Yes', 'woodmart' ),
					'no'      => esc_html__( 'No', 'woodmart' ),
				),
				'default'      => 'inherit',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render the widget output on the frontend.
	 */
	protected function render() {
		$settings = wp_parse_args(
			$this->get_settings_for_display(),
			array(
				'products_view'            => 'inherit',
				'products_columns'         => 'inherit',
				'products_columns_tablet'  => 'inherit',
				'products_columns_mobile'  => 'inherit',
				'products_spacing'         => 'inherit',
				'products_spacing_tablet'  => 'inherit',
				'products_spacing_mobile'  => 'inherit',
				'shop_pagination'          => 'inherit',
				'product_hover'            => 'inherit',
				'products_bordered_grid'   => 'inherit',
				'img_size'                 => '',
				'img_size_custom'          => '',
				'products_color_scheme'    => 'inherit',
				'products_with_background' => 'inherit',
				'products_shadow'          => 'inherit',
			)
		);

		if ( 'yes' === $settings['products_with_background'] ) {
			$products_with_background = '1';
		} else if ( 'no' === $settings['products_with_background'] ) {
			$products_with_background = '0';
		}

		if ( 'yes' === $settings['products_shadow'] ) {
			$products_shadow = '1';
		} else if ( 'no' === $settings['products_shadow'] ) {
			$products_shadow = '0';
		}

		if ( ! empty( $settings['img_size'] ) ) {
			woodmart_set_loop_prop( 'img_size', $settings['img_size'] );
		}

		if ( ! empty( $settings['img_size_custom']['width'] ) || ! empty( $settings['img_size_custom']['height'] ) ) {
			woodmart_set_loop_prop( 'img_size_custom', $settings['img_size_custom'] );
		}

		Main::setup_preview();

		woodmart_sticky_loader( ' wd-content-loader' );

		if ( 'inherit' !== $settings['products_view'] ) {
			woodmart_set_loop_prop( 'products_view', woodmart_new_get_shop_view( $settings['products_view'], true ) );
		}

		if ( 'inherit' !== $settings['products_columns'] ) {
			woodmart_set_loop_prop( 'products_columns', woodmart_new_get_products_columns_per_row( $settings['products_columns'], true ) );
		}

		if ( 'inherit' !== $settings['products_columns_tablet'] ) {
			woodmart_set_loop_prop( 'products_columns_tablet', $settings['products_columns_tablet'] );
		}

		if ( 'inherit' !== $settings['products_columns_mobile'] ) {
			woodmart_set_loop_prop( 'products_columns_mobile', $settings['products_columns_mobile'] );
		}

		if ( 'inherit' !== $settings['products_spacing'] ) {
			woodmart_set_loop_prop( 'products_spacing', $settings['products_spacing'] );
		}

		if ( $settings['products_spacing_tablet'] && 'inherit' !== $settings['products_spacing_tablet'] ) {
			woodmart_set_loop_prop( 'products_spacing_tablet', $settings['products_spacing_tablet'] );
		}

		if ( $settings['products_spacing_mobile'] && 'inherit' !== $settings['products_spacing_mobile'] ) {
			woodmart_set_loop_prop( 'products_spacing_mobile', $settings['products_spacing_mobile'] );
		}

		if ( 'inherit' !== $settings['product_hover'] && ! empty( $settings['product_hover'] ) ) {
			woodmart_set_loop_prop( 'product_hover', $settings['product_hover'] );
		}

		if ( 'inherit' !== $settings['shop_pagination'] ) {
			Global_Data::get_instance()->set_data( 'shop_pagination', $settings['shop_pagination'] );
		}

		if ( 'inherit' !== $settings['products_bordered_grid'] ) {
			woodmart_set_loop_prop( 'products_bordered_grid', $settings['products_bordered_grid'] );
		}

		if ( $settings['products_bordered_grid_style'] && 'inherit' !== $settings['products_bordered_grid_style'] ) {
			woodmart_set_loop_prop( 'products_bordered_grid_style', $settings['products_bordered_grid_style'] );
		}

		if ( $settings['products_color_scheme'] && 'inherit' !== $settings['products_color_scheme'] ) {
			woodmart_set_loop_prop( 'products_color_scheme', $settings['products_color_scheme'] );
		}

		if ( isset( $products_with_background ) ) {
			woodmart_set_loop_prop( 'products_with_background', $products_with_background );
		}

		if ( isset( $products_shadow ) ) {
			woodmart_set_loop_prop( 'products_shadow', $products_shadow );
		}

		do_action( 'woodmart_woocommerce_main_loop' );

		Main::restore_preview();
	}
}

Plugin::instance()->widgets_manager->register( new Archive_Products() );
