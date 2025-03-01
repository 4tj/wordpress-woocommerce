<?php
/**
 * Product filters map.
 */

namespace XTS\Elementor;

use Elementor\Group_Control_Typography;
use Elementor\Repeater;
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Plugin;
use WC_Tax;
use WOODMART_Custom_Walker_Category;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

/**
 * Elementor widget that inserts an embeddable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Product_Filters extends Widget_Base {
	/**
	 * Get widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'wd_product_filters';
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
		return esc_html__( 'Product filters', 'woodmart' );
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
		return 'wd-icon-product-filters';
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
	 * Get product attributes.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_attributes() {
		$output = array(
			'' => esc_html__( 'Select', 'woodmart' ),
		);

		if ( taxonomy_exists( 'product_brand' ) ) {
			$taxonomy = get_taxonomy( 'product_brand' );
			$label    = $taxonomy->labels->singular_name;

			$output['product_brand'] = sprintf( _x( 'Product %s', 'Product Attribute', 'woocommerce' ), $label );
		}

		$taxonomies = wc_get_attribute_taxonomies();

		if ( $taxonomies ) {
			foreach ( $taxonomies as $tax ) {
				$output[ $tax->attribute_name ] = $tax->attribute_name;
			}
		}

		return $output;
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
			'submit_form_on',
			array(
				'label'   => esc_html__( 'Submit form on', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'click'  => esc_html__( 'Button click', 'woodmart' ),
					'select' => esc_html__( 'Dropdown select', 'woodmart' ),
				),
				'default' => 'click',
			)
		);

		$this->add_control(
			'show_selected_values',
			array(
				'label'        => esc_html__( 'Show selected values in dropdown', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => 'yes',
				'return_value' => 'yes',
			)
		);

		$this->add_control(
			'show_dropdown_on',
			array(
				'label'   => esc_html__( 'Show dropdown on', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'hover' => esc_html__( 'Hover', 'woodmart' ),
					'click' => esc_html__( 'Click', 'woodmart' ),
				),
				'default' => 'click',
			)
		);

		$this->end_controls_section();

		/**
		 * Filters settings.
		 */
		$this->start_controls_section(
			'filters_content_section',
			array(
				'label' => esc_html__( 'Filters', 'woodmart' ),
			)
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'filter_type',
			array(
				'label'   => esc_html__( 'Filter type', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'categories' => esc_html__( 'Categories', 'woodmart' ),
					'attributes' => esc_html__( 'Attributes', 'woodmart' ),
					'stock'      => esc_html__( 'Stock status', 'woodmart' ),
					'price'      => esc_html__( 'Price', 'woodmart' ),
					'orderby'    => esc_html__( 'Order by', 'woodmart' ),
				),
				'default' => 'categories',
			)
		);

		/**
		 * Categories settings.
		 */
		$repeater->add_control(
			'categories_title',
			array(
				'label'     => esc_html__( 'Title', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Categories',
				'condition' => array(
					'filter_type' => 'categories',
				),
			)
		);

		$repeater->add_control(
			'order_by',
			array(
				'label'     => esc_html__( 'Order by', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'name',
				'options'   => array(
					'name'  => esc_html__( 'Name', 'woodmart' ),
					'id'    => esc_html__( 'ID', 'woodmart' ),
					'slug'  => esc_html__( 'Slug', 'woodmart' ),
					'count' => esc_html__( 'Count', 'woodmart' ),
					'order' => esc_html__( 'Category order', 'woodmart' ),
				),
				'condition' => array(
					'filter_type' => 'categories',
				),
			)
		);

		$repeater->add_control(
			'hierarchical',
			array(
				'label'        => esc_html__( 'Show hierarchy', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'filter_type' => 'categories',
				),
			)
		);

		$repeater->add_control(
			'hide_empty',
			array(
				'label'        => esc_html__( 'Hide empty categories', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'filter_type' => 'categories',
				),
			)
		);

		$repeater->add_control(
			'show_categories_ancestors',
			array(
				'label'        => esc_html__( 'Show current category ancestors', 'woodmart' ),
				'description'  => esc_html__( 'If you visit category Man, for example, only man\'s subcategories will be shown in the page title like T-shirts, Coats, Shoes etc.', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '0',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'filter_type' => 'categories',
				),
			)
		);

		/**
		 * Attributes settings.
		 */
		$repeater->add_control(
			'attributes_title',
			array(
				'label'     => esc_html__( 'Title', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Filter by',
				'condition' => array(
					'filter_type' => 'attributes',
				),
			)
		);

		$repeater->add_control(
			'attribute',
			array(
				'label'     => esc_html__( 'Attribute', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => $this->get_attributes(),
				'default'   => '',
				'condition' => array(
					'filter_type' => 'attributes',
				),
			)
		);

		$repeater->add_control(
			'categories',
			array(
				'label'       => esc_html__( 'Show in categories', 'woodmart' ),
				'description' => esc_html__( 'Choose on which categories pages you want to display this filter. Or leave empty to show on all pages.', 'woodmart' ),
				'type'        => 'wd_autocomplete',
				'search'      => 'woodmart_get_taxonomies_by_query',
				'render'      => 'woodmart_get_taxonomies_title_by_id',
				'taxonomy'    => array( 'product_cat' ),
				'multiple'    => true,
				'label_block' => true,
				'condition'   => array(
					'filter_type' => 'attributes',
				),
			)
		);

		$repeater->add_control(
			'query_type',
			array(
				'label'     => esc_html__( 'Query type', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'and',
				'options'   => array(
					'or'  => esc_html__( 'OR', 'woodmart' ),
					'and' => esc_html__( 'AND', 'woodmart' ),
				),
				'condition' => array(
					'filter_type' => 'attributes',
				),
			)
		);

		$repeater->add_control(
			'size',
			array(
				'label'     => esc_html__( 'Swatches size', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'normal',
				'options'   => array(
					'small'  => esc_html__( 'Small', 'woodmart' ),
					'normal' => esc_html__( 'Medium', 'woodmart' ),
					'large'  => esc_html__( 'Large', 'woodmart' ),
				),
				'condition' => array(
					'filter_type' => 'attributes',
				),
			)
		);

		$repeater->add_control(
			'shape',
			array(
				'label'     => esc_html__( 'Swatches shape', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'round',
				'options'   => array(

					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'round'   => esc_html__( 'Round', 'woodmart' ),
					'rounded' => esc_html__( 'Rounded', 'woodmart' ),
					'square'  => esc_html__( 'Square', 'woodmart' ),
				),
				'condition' => array(
					'filter_type' => 'attributes',
				),
			)
		);

		$repeater->add_control(
			'swatches_style',
			array(
				'label'     => esc_html__( 'Swatches style', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'inherit',
				'options'   => array(
					'inherit' => esc_html__( 'Inherit', 'woodmart' ),
					'1'       => esc_html__( 'Style 1', 'woodmart' ),
					'2'       => esc_html__( 'Style 2', 'woodmart' ),
					'3'       => esc_html__( 'Style 3', 'woodmart' ),
					'4'       => esc_html__( 'Style 4', 'woodmart' ),
				),
				'condition' => array(
					'filter_type' => 'attributes',
				),
			)
		);

		$repeater->add_control(
			'display',
			array(
				'label'     => esc_html__( 'Layout', 'woodmart' ),
				'type'      => Controls_Manager::SELECT,
				'options'   => array(
					'list'   => esc_html__( 'List', 'woodmart' ),
					'double' => esc_html__( '2 columns', 'woodmart' ),
					'inline' => esc_html__( 'Inline', 'woodmart' ),
				),
				'condition' => array(
					'filter_type' => 'attributes',
				),
				'default'   => 'list',
			)
		);

		$repeater->add_control(
			'labels',
			array(
				'label'        => esc_html__( 'Show labels', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'filter_type' => 'attributes',
				),
			)
		);

		/**
		 * Stock settings.
		 */
		$repeater->add_control(
			'stock_title',
			array(
				'label'     => esc_html__( 'Title', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Stock status',
				'condition' => array(
					'filter_type' => 'stock',
				),
			)
		);

		$repeater->add_control(
			'onsale',
			array(
				'label'        => esc_html__( 'On Sale filter', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'filter_type' => 'stock',
				),
			)
		);

		$repeater->add_control(
			'instock',
			array(
				'label'        => esc_html__( 'In Stock filter', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'filter_type' => 'stock',
				),
			)
		);

		$repeater->add_control(
			'onbackorder',
			array(
				'label'        => esc_html__( 'On Backorder filter', 'woodmart' ),
				'type'         => Controls_Manager::SWITCHER,
				'default'      => '1',
				'label_on'     => esc_html__( 'Yes', 'woodmart' ),
				'label_off'    => esc_html__( 'No', 'woodmart' ),
				'return_value' => '1',
				'condition'    => array(
					'filter_type' => 'stock',
				),
			)
		);

		/**
		 * Price settings.
		 */
		$repeater->add_control(
			'price_title',
			array(
				'label'     => esc_html__( 'Title', 'woodmart' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => 'Filter by price',
				'condition' => array(
					'filter_type' => 'price',
				),
			)
		);

		/**
		 * Repeater settings.
		 */
		$this->add_control(
			'items',
			array(
				'type'        => Controls_Manager::REPEATER,
				'title_field' => '{{{ filter_type }}}',
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'filter_type' => 'categories',
					),
					array(
						'filter_type' => 'attributes',
					),
					array(
						'filter_type' => 'stock',
					),
					array(
						'filter_type' => 'price',
					),
				),
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
			'style',
			array(
				'label'   => esc_html__( 'Style', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'simplified'      => esc_html__( 'Simplified', 'woodmart' ),
					'form'            => esc_html__( 'Form', 'woodmart' ),
					'form-underlined' => esc_html__( 'Form underlined', 'woodmart' ),
				),
				'default' => 'form',
			)
		);

		$this->add_control(
			'display_grid',
			array(
				'label'   => esc_html__( 'Display grid', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'stretch' => esc_html__( 'Stretch', 'woodmart' ),
					'inline'  => esc_html__( 'Inline', 'woodmart' ),
					'number'  => esc_html__( 'Number', 'woodmart' ),
				),
				'default' => 'stretch',
			)
		);

		$this->add_responsive_control(
			'display_grid_col',
			array(
				'label'       => esc_html__( 'Columns', 'woodmart' ),
				'type'        => Controls_Manager::SLIDER,
				'default'     => array(
					'size' => 4,
				),
				'range'       => array(
					'px' => array(
						'min'  => 1,
						'max'  => 12,
						'step' => 1,
					),
				),
				'condition'   => array(
					'display_grid' => 'number',
				),
				'render_type' => 'template',
			)
		);

		$this->add_responsive_control(
			'space_between',
			array(
				'label'     => esc_html__( 'Space between', 'woodmart' ),
				'type'      => Controls_Manager::SLIDER,
				'default'   => array(
					'size' => 10,
				),
				'range'     => array(
					'px' => array(
						'min'  => 0,
						'max'  => 30,
						'step' => 1,
					),
				),
				'selectors' => array(
					'{{WRAPPER}}' => '--wd-gap: {{SIZE}}px',
				),
				'render_type' => 'template',
				'devices'     => array( 'desktop', 'tablet', 'mobile' ),
				'classes'     => 'wd-hide-custom-breakpoints',
			)
		);

		$this->add_control(
			'woodmart_color_scheme',
			array(
				'label'   => esc_html__( 'Color scheme', 'woodmart' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					''      => esc_html__( 'Inherit', 'woodmart' ),
					'light' => esc_html__( 'Light', 'woodmart' ),
					'dark'  => esc_html__( 'Dark', 'woodmart' ),
				),
				'default' => '',
			)
		);

		$this->end_controls_section();

		/**
		 * Title settings.
		 */
		$this->start_controls_section(
			'title_style_section',
			array(
				'label' => esc_html__( 'Title', 'woodmart' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->start_controls_tabs( 'color_tabs' );

		$this->start_controls_tab(
			'title_idle_color_tab',
			array(
				'label' => esc_html__( 'Idle', 'woodmart' ),
			)
		);

		$this->add_control(
			'title_idle_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .title-text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_brd_color',
			array(
				'label'     => esc_html__( 'Border color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-product-filters' => '--wd-form-brd-color: {{VALUE}};',
				),
				'condition' => array(
					'style' => array( 'form', 'form-underlined' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'title_hover_color_tab',
			array(
				'label' => esc_html__( 'Hover', 'woodmart' ),
			)
		);

		$this->add_control(
			'title_hover_color',
			array(
				'label'     => esc_html__( 'Color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-pf-checkboxes:hover .title-text, {{WRAPPER}} .wd-pf-checkboxes.wd-opened .title-text' => 'color: {{VALUE}}',
				),
			)
		);

		$this->add_control(
			'form_brd_color_focus',
			array(
				'label'     => esc_html__( 'Border color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-product-filters' => '--wd-form-brd-color-focus: {{VALUE}};',
				),
				'condition' => array(
					'style' => array( 'form', 'form-underlined' ),
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_control(
			'form_bg',
			array(
				'label'     => esc_html__( 'Background color', 'woodmart' ),
				'type'      => Controls_Manager::COLOR,
				'selectors' => array(
					'{{WRAPPER}} .wd-product-filters' => '--wd-form-bg: {{VALUE}};',
				),
				'condition' => array(
					'style' => array( 'form' ),
				),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => esc_html__( 'Typography', 'woodmart' ),
				'selector' => '{{WRAPPER}} .title-text',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Retrieve the list of script dependencies the element requires.
	 *
	 * @return array Element scripts dependencies.
	 */
	public function get_script_depends() {
		return array(
			'jquery-ui-slider',
			'accounting',
			'wc-price-slider',
		);
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
		global $wp;

		$default_settings = array(
			'woodmart_color_scheme'   => 'dark',
			'items'                   => array(),
			'submit_form_on'          => 'click',
			'show_selected_values'    => 'yes',
			'show_dropdown_on'        => 'click',
			'style'                   => 'form',
			'display_grid'            => 'stretch',
			'display_grid_col'        => array( 'size' => 4 ),
			'display_grid_col_tablet' => array( 'size' => '' ),
			'display_grid_col_mobile' => array( 'size' => '' ),
			'space_between'           => array( 'size' => 10 ),
			'space_between_tablet'    => array( 'size' => '' ),
			'space_between_mobile'    => array( 'size' => '' ),
		);

		$settings = wp_parse_args( $this->get_settings_for_display(), $default_settings );

		$form_action = wc_get_page_permalink( 'shop' );

		if ( woodmart_is_shop_archive() && apply_filters( 'woodmart_filters_form_action_without_cat_widget', true ) ) {
			if ( '' === get_option( 'permalink_structure' ) ) {
				$form_action = remove_query_arg( array( 'page', 'paged', 'product-page' ), add_query_arg( $wp->query_string, '', home_url( $wp->request ) ) );
			} else {
				if ( is_search() ) {
					$home_url = add_query_arg( $wp->query_vars, home_url() );
				} else {
					$home_url = home_url( trailingslashit( $wp->request ) );
				}

				$form_action = preg_replace( '%\/page/[0-9]+%', '', $home_url );
			}
		}

		$this->add_render_attribute(
			array(
				'wrapper' => array(
					'class'  => array(
						'wd-product-filters',
						woodmart_get_old_classes( 'woodmart-product-filters' ),
						'wd-style-' . $settings['style'],
						$settings['woodmart_color_scheme'] ? 'color-scheme-' . $settings['woodmart_color_scheme'] : '',
					),
					'action' => array(
						$form_action,
					),
					'method' => array(
						'GET',
					),
				),
			)
		);

		if ( 'number' === $settings['display_grid'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'wd-grid-g' );

			$this->add_render_attribute(
				'wrapper',
				'style',
				woodmart_get_grid_attrs(
					array(
						'columns'        => $settings['display_grid_col']['size'],
						'columns_tablet' => $settings['display_grid_col_tablet']['size'],
						'columns_mobile' => $settings['display_grid_col_mobile']['size'],
					)
				)
			);
		} elseif ( 'inline' === $settings['display_grid'] ) {
			$this->add_render_attribute( 'wrapper', 'class', 'wd-grid-f-inline' );
		} else {
			$this->add_render_attribute( 'wrapper', 'class', 'wd-grid-f-stretch' );
		}

		$this->add_render_attribute( 'wrapper', 'style', '--wd-gap-lg:' . $settings['space_between']['size'] . 'px;' );

		if ( isset( $settings['space_between_tablet']['size'] ) && '' !== $settings['space_between_tablet']['size'] ) {
			$this->add_render_attribute( 'wrapper', 'style', '--wd-gap-md:' . $settings['space_between_tablet']['size'] . 'px;' );
		}
		if ( isset( $settings['space_between_mobile']['size'] ) && '' !== $settings['space_between_mobile']['size'] ) {
			$this->add_render_attribute( 'wrapper', 'style', '--wd-gap-sm:' . $settings['space_between_mobile']['size'] . 'px;' );
		}

		if ( woodmart_is_shop_archive() ) {
			$this->add_render_attribute( 'wrapper', 'class', 'with-ajax' );
		}

		woodmart_enqueue_inline_style( 'el-product-filters' );
		woodmart_enqueue_inline_style( 'woo-mod-swatches-base' );
		woodmart_enqueue_inline_style( 'woo-mod-swatches-filter' );

		woodmart_enqueue_js_script( 'product-filters' );
		?>
		<form <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>
			<?php foreach ( $settings['items'] as $index => $item ) : ?>
				<?php
				$item['show_selected_values'] = $settings['show_selected_values'];
				$item['show_dropdown_on']     = $settings['show_dropdown_on'];
				?>

				<?php if ( 'categories' === $item['filter_type'] ) : ?>
					<?php $this->categories_filter_template( $item ); ?>
				<?php elseif ( 'attributes' === $item['filter_type'] ) : ?>
					<?php $this->attributes_filter_template( $item ); ?>
				<?php elseif ( 'stock' === $item['filter_type'] ) : ?>
					<?php $this->stock_filter_template( $item ); ?>
				<?php elseif ( 'price' === $item['filter_type'] ) : ?>
					<?php $item['submit_form_on'] = $settings['submit_form_on']; ?>
					<?php $this->price_filter_template( $item ); ?>
				<?php elseif ( 'orderby' === $item['filter_type'] ) : ?>
					<?php $this->orderby_filter_template( $item ); ?>
				<?php endif; ?>
			<?php endforeach; ?>

		<?php if ( 'click' === $settings['submit_form_on'] ) : ?>
			<div class="wd-pf-btn wd-col">
				<button type="submit">
					<?php esc_html_e( 'Filter', 'woodmart' ); ?>
				</button>
			</div>
		<?php endif; ?>
		</form>
		<?php
	}

	public function price_filter_template( $settings ) {
		$default_settings = array(
			'price_title'      => esc_html__( 'Filter by price', 'woodmart' ),
			'show_dropdown_on' => 'click',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		woodmart_enqueue_inline_style( 'widget-slider-price-filter' );

		wp_localize_script(
			'woodmart-theme',
			'woocommerce_price_slider_params',
			array(
				'currency_format_num_decimals' => 0,
				'currency_format_symbol'       => get_woocommerce_currency_symbol(),
				'currency_format_decimal_sep'  => esc_attr( wc_get_price_decimal_separator() ),
				'currency_format_thousand_sep' => esc_attr( wc_get_price_thousand_separator() ),
				'currency_format'              => esc_attr( str_replace( array( '%1$s', '%2$s' ), array( '%s', '%v' ), get_woocommerce_price_format() ) ),
			)
		);
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'wc-jquery-ui-touchpunch' );
		wp_enqueue_script( 'accounting' );
		wp_enqueue_script( 'wc-price-slider' );

		$link = woodmart_filters_get_page_base_url();

		$prices    = woodmart_get_filtered_price_new();
		$min_price = isset( $prices->min_price ) ? $prices->min_price : 0;
		$max_price = isset( $prices->max_price ) ? $prices->max_price : 0;

		// Check to see if we should add taxes to the prices if store are excl tax but display incl.
		if ( wc_tax_enabled() && ! wc_prices_include_tax() && 'incl' === get_option( 'woocommerce_tax_display_shop' ) ) {
			$tax_class = apply_filters( 'woocommerce_price_filter_widget_tax_class', '' ); // Uses standard tax class.
			$tax_rates = WC_Tax::get_rates( $tax_class );

			if ( $tax_rates ) {
				$min_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $min_price, $tax_rates ) );
				$max_price += WC_Tax::get_tax_total( WC_Tax::calc_exclusive_tax( $max_price, $tax_rates ) );
			}
		}

		$min = apply_filters( 'woocommerce_price_filter_widget_min_amount', floor( $min_price ) );
		$max = apply_filters( 'woocommerce_price_filter_widget_max_amount', ceil( $max_price ) );

		if ( $min === $max || ( ( is_shop() || is_product_taxonomy() ) && ! wc()->query->get_main_query()->post_count && ! $max ) ) {
			return;
		}

		$min_price = isset( $_GET['min_price'] ) ? wc_clean( wp_unslash( $_GET['min_price'] ) ) : $min;
		$max_price = isset( $_GET['max_price'] ) ? wc_clean( wp_unslash( $_GET['max_price'] ) ) : $max;

		?>
		<div class="wd-pf-checkboxes wd-pf-price-range multi_select widget_price_filter wd-col wd-event-<?php echo esc_attr( $settings['show_dropdown_on'] ); ?>">
			<div class="wd-pf-title">
				<span class="title-text">
					<?php echo esc_html( $settings['price_title'] ); ?>
				</span>

				<?php if ( $settings['show_selected_values'] ) : ?>
					<ul class="wd-pf-results"></ul>
				<?php endif; ?>
			</div>

			<div class="wd-pf-dropdown wd-dropdown">
				<div class="price_slider_wrapper">
					<div class="price_slider_widget" style="display:none;"></div>

					<div class="filter_price_slider_amount">
						<input type="hidden" class="min_price" name="min_price" value="<?php echo esc_attr( $min_price ); ?>" data-min="<?php echo esc_attr( $min ); ?>">
						<input type="hidden" class="max_price" name="max_price" value="<?php echo esc_attr( $max_price ); ?>" data-max="<?php echo esc_attr( $max ); ?>">

						<?php if ( 'select' === $settings['submit_form_on'] ) : ?>
							<a href="<?php echo esc_url( $link ); ?>" class="button pf-value"><?php echo esc_html__( 'Filter', 'woodmart' ); ?></a>
						<?php endif; ?>

						<div class="price_label" style="display:none;">
							<span class="from"></span>
							<span class="to"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function stock_filter_template( $settings ) {
		$default_settings = array(
			'stock_title'      => esc_html__( 'Stock status', 'woodmart' ),
			'instock'          => 1,
			'onsale'           => 1,
			'onbackorder'      => 1,
			'show_dropdown_on' => 'click',
		);
		$settings         = wp_parse_args( $settings, $default_settings );
		$filter_name      = 'stock_status';
		$current_filter   = isset( $_GET[ $filter_name ] ) ? explode( ',', $_GET[ $filter_name ] ) : array();
		$result_value     = isset( $_GET[ $filter_name ] ) ? $_GET[ $filter_name ] : '';
		$link             = woodmart_filters_get_page_base_url();
		$options          = array(
			'onsale'      => esc_html__( 'On sale', 'woodmart' ),
			'instock'     => esc_html__( 'In stock', 'woodmart' ),
			'onbackorder' => esc_html__( 'On backorder', 'woodmart' ),
		);

		foreach ( $options as $key => $value ) {
			if ( ! $settings[ $key ] ) {
				unset( $options[ $key ] );
			}
		}
		?>
		<div class="wd-pf-checkboxes wd-pf-stock multi_select wd-col wd-event-<?php echo esc_attr( $settings['show_dropdown_on'] ); ?>">
			<input type="hidden" class="result-input" name="stock_status" value="<?php echo esc_attr( $result_value ); ?>">

			<div class="wd-pf-title">
				<span class="title-text">
					<?php echo esc_html( $settings['stock_title'] ); ?>
				</span>

				<?php if ( $settings['show_selected_values'] ) : ?>
					<ul class="wd-pf-results">
						<?php if ( isset( $current_filter ) && ! empty( $current_filter ) ) : ?>
							<?php foreach ( $current_filter as $filter ) : ?>
								<?php if ( isset( $options[ $filter ] ) ) : ?>
									<li class="selected-value" data-title="<?php echo esc_attr( $filter ); ?>">
										<?php echo esc_attr( $options[ $filter ] ); ?>
									</li>
								<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="wd-pf-dropdown wd-dropdown">
				<div class="wd-scroll">
					<ul class="wd-scroll-content">
						<?php foreach ( $options as $slug => $name ) : ?>
							<?php
							$current_filter   = ! empty( $_GET[ $filter_name ] ) ? explode( ',', $_GET[ $filter_name ] ) : array();
							$is_active_filter = in_array( $slug, $current_filter, true );
							$link             = remove_query_arg( $filter_name, $link );

							if ( $is_active_filter ) {
								$remove_key = array_search( $slug, $current_filter, true );
								unset( $current_filter[ $remove_key ] );
							} else {
								$current_filter[] = $slug;
							}

							if ( ! empty( $current_filter ) ) {
								$link = add_query_arg(
									array(
										$filter_name => implode( ',', $current_filter ),
									),
									$link
								);
							}

							$link = str_replace( '%2C', ',', $link );
							?>

							<li class="<?php echo $is_active_filter ? esc_attr( 'wd-active' ) : ''; ?>">
								<a href="<?php echo esc_url( $link ); ?>" rel="nofollow noopener" class="pf-value" data-val="<?php echo esc_attr( $slug ); ?>" data-title="<?php echo esc_attr( $name ); ?>">
									<?php echo esc_html( $name ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}

	public function orderby_filter_template( $settings ) {
		$options = apply_filters(
			'woocommerce_catalog_orderby',
			array(
				'menu_order' => esc_html__( 'Default sorting', 'woocommerce' ),
				'popularity' => esc_html__( 'Sort by popularity', 'woocommerce' ),
				'rating'     => esc_html__( 'Sort by average rating', 'woocommerce' ),
				'date'       => esc_html__( 'Sort by latest', 'woocommerce' ),
				'price'      => esc_html__( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => esc_html__( 'Sort by price: high to low', 'woocommerce' ),
			)
		);

		$default_settings = array(
			'show_dropdown_on' => 'click',
		);
		$settings         = wp_parse_args( $settings, $default_settings );
		$current_filter   = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : '';
		$link             = woodmart_filters_get_page_base_url();
		?>
		<div class="wd-pf-checkboxes wd-pf-sortby wd-col wd-event-<?php echo esc_attr( $settings['show_dropdown_on'] ); ?>">
			<input type="hidden" class="result-input" name="orderby" value="<?php echo ! empty( $current_filter ) ? esc_attr( $current_filter ) : ''; ?>">

			<div class="wd-pf-title">
				<span class="title-text">
					<?php echo esc_html__( 'Sort by', 'woodmart' ); ?>
				</span>

				<?php if ( $settings['show_selected_values'] ) : ?>
					<ul class="wd-pf-results">
						<?php if ( ! empty( $current_filter ) && array_key_exists( $current_filter, $options ) ) : ?>
							<li class="selected-value" data-title="<?php echo esc_attr( $current_filter ); ?>">
								<?php echo esc_attr( $options[ $current_filter ] ); ?>
							</li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="wd-pf-dropdown wd-dropdown">
				<div class="wd-scroll">
					<ul class="wd-scroll-content">
						<?php foreach ( $options as $key => $value ) : ?>
							<?php
							$is_active_filter = $key === $current_filter;
							$link             = add_query_arg(
								array(
									'orderby' => $key,
								),
								$link
							);

							if ( $is_active_filter ) {
								$link = remove_query_arg(
									'orderby',
									$link
								);
							}
							?>

							<li class="<?php echo $is_active_filter ? esc_attr( 'wd-active' ) : ''; ?>">
								<a href="<?php echo esc_url( $link ); ?>" rel="nofollow noopener" class="pf-value" data-val="<?php echo esc_attr( $key ); ?>" data-title="<?php echo esc_attr( $value ); ?>">
									<?php echo esc_html( $value ); ?>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}

	public function attributes_filter_template( $settings ) {
		$default_settings = array(
			'attributes_title'     => esc_html__( 'Filter by', 'woodmart' ),
			'attribute'            => '',
			'categories'           => '',
			'query_type'           => 'and',
			'size'                 => 'normal',
			'shape'                => 'inherit',
			'swatches_style'       => 'inherit',
			'display'              => 'list',
			'labels'               => 1,
			'show_selected_values' => 'yes',
			'show_dropdown_on'     => 'yes',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		the_widget(
			'WOODMART_Widget_Layered_Nav',
			array(
				'template'             => 'filter-element',
				'attribute'            => $settings['attribute'],
				'query_type'           => $settings['query_type'],
				'size'                 => $settings['size'],
				'style'                => $settings['swatches_style'],
				'shape'                => $settings['shape'],
				'labels'               => $settings['labels'],
				'display'              => $settings['display'],
				'filter-title'         => $settings['attributes_title'],
				'categories'           => $settings['categories'] ? $settings['categories'] : array(),
				'show_selected_values' => isset( $settings['show_selected_values'] ) ? $settings['show_selected_values'] : 'yes',
				'show_dropdown_on'     => isset( $settings['show_dropdown_on'] ) ? $settings['show_dropdown_on'] : 'click',
			),
			array(
				'before_widget' => '',
				'after_widget'  => '',
			)
		);
	}

	public function categories_filter_template( $settings ) {
		global $wp_query;

		$default_settings = array(
			'categories_title'          => esc_html__( 'Categories', 'woodmart' ),
			'hierarchical'              => 1,
			'order_by'                  => 'name',
			'hide_empty'                => '',
			'show_categories_ancestors' => '',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$list_args = array(
			'hierarchical'       => $settings['hierarchical'],
			'taxonomy'           => 'product_cat',
			'hide_empty'         => $settings['hide_empty'],
			'title_li'           => false,
			'walker'             => new WOODMART_Custom_Walker_Category(),
			'use_desc_for_title' => false,
			'orderby'            => $settings['order_by'],
			'echo'               => false,
		);

		if ( 'order' === $settings['order_by'] ) {
			$list_args['orderby']  = 'meta_value_num';
			$list_args['meta_key'] = 'order';
		}

		$cat_ancestors = array();

		if ( is_tax( 'product_cat' ) ) {
			$current_cat   = $wp_query->queried_object;
			$cat_ancestors = get_ancestors( $current_cat->term_id, 'product_cat' );
		}

		if ( isset( $current_cat ) ) {
			$list_args['current_category'] = $current_cat->term_id;
		} else {
			$list_args['current_category'] = '';
		}

		$list_args['current_category_ancestors'] = $cat_ancestors;
		$list_args['active_filter_url']          = woodmart_filters_get_page_base_url();

		if ( $settings['show_categories_ancestors'] && isset( $current_cat ) ) {
			$is_cat_has_children = get_term_children( $current_cat->term_id, 'product_cat' );
			if ( $is_cat_has_children ) {
				$list_args['child_of'] = $current_cat->term_id;
			} elseif ( $current_cat->parent != 0 ) {
				$list_args['child_of'] = $current_cat->parent;
			}
			$list_args['depth'] = 1;
		}

		?>
		<div class="wd-pf-checkboxes wd-pf-categories wd-col wd-event-<?php echo esc_attr( $settings['show_dropdown_on'] ); ?>">
			<div class="wd-pf-title">
				<span class="title-text">
					<?php echo esc_html( $settings['categories_title'] ); ?>
				</span>

				<?php if ( $settings['show_selected_values'] ) : ?>
					<ul class="wd-pf-results">
						<?php if ( isset( $current_cat ) && ! is_null( $current_cat ) ) : ?>
							<li class="selected-value" data-title="<?php echo esc_attr( $current_cat->slug ); ?>">
								<?php echo esc_attr( $current_cat->name ); ?>
							</li>
						<?php endif; ?>
					</ul>
				<?php endif; ?>
			</div>

			<div class="wd-pf-dropdown wd-dropdown">
				<div class="wd-scroll">
					<ul class="wd-scroll-content">
						<?php if ( $settings['show_categories_ancestors'] && isset( $current_cat ) && isset( $is_cat_has_children ) && $is_cat_has_children ) : ?>
							<li style="display:none;" class="wd-active cat-item cat-item-<?php echo $current_cat->term_id; ?>">
								<a class="pf-value" href="<?php echo esc_url( get_category_link( $current_cat->term_id ) ); ?>" data-val="<?php echo esc_attr( $current_cat->slug ); ?>" data-title="<?php echo esc_attr( $current_cat->name ); ?>">
									<?php echo esc_html( $current_cat->name ); ?>
								</a>
							</li>
						<?php endif; ?>

						<?php echo wp_list_categories( $list_args ); ?>
					</ul>
				</div>
			</div>
		</div>
		<?php
	}
}

Plugin::instance()->widgets_manager->register( new Product_Filters() );
