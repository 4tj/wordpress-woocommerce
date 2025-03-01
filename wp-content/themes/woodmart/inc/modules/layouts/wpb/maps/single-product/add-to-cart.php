<?php
/**
 * Add to cart map.
 *
 * @package Woodmart
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_get_vc_map_single_product_add_to_cart' ) ) {
	/**
	 * Content map.
	 */
	function woodmart_get_vc_map_single_product_add_to_cart() {
		$button_typography = woodmart_get_typography_map(
			array(
				'key'      => 'button',
				'selector' => '{{WRAPPER}} .single_add_to_cart_button',
			)
		);

		$main_price_typography = woodmart_get_typography_map(
			array(
				'key'           => 'main_price',
				'selector'      => '{{WRAPPER}} .woocommerce-variation-price .price',
				'group'         => esc_html__( 'Style', 'woodmart' ),
				'wd_dependency' => array(
					'element' => 'price_style_tabs',
					'value'   => array( 'main_price' ),
				),
			)
		);

		$old_price_typography = woodmart_get_typography_map(
			array(
				'key'           => 'old_price',
				'selector'      => '{{WRAPPER}} .woocommerce-variation-price .price del, {{WRAPPER}} .woocommerce-variation-price del .amount',
				'group'         => esc_html__( 'Style', 'woodmart' ),
				'wd_dependency' => array(
					'element' => 'price_style_tabs',
					'value'   => array( 'old_price' ),
				),
			)
		);

		$suffix_typography = woodmart_get_typography_map(
			array(
				'key'           => 'suffix',
				'selector'      => '{{WRAPPER}} .woocommerce-price-suffix',
				'group'         => esc_html__( 'Style', 'woodmart' ),
				'wd_dependency' => array(
					'element' => 'price_style_tabs',
					'value'   => array( 'suffix' ),
				),
			)
		);

		return array(
			'base'        => 'woodmart_single_product_add_to_cart',
			'name'        => esc_html__( 'Product add to cart', 'woodmart' ),
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Single product elements', 'woodmart' ), 'single_product' ),
			'description' => esc_html__( 'Add to cart form and button', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/sp-icons/sp-add-to-cart.svg',
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),

				array(
					'heading'          => esc_html__( 'Alignment', 'woodmart' ),
					'type'             => 'wd_select',
					'param_name'       => 'alignment',
					'style'            => 'images',
					'selectors'        => array(),
					'devices'          => array(
						'desktop' => array(
							'value' => 'left',
						),
					),
					'value'            => array(
						esc_html__( 'Left', 'woodmart' ) => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' ) => 'right',
					),
					'images'           => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Button.
				array(
					'title'      => esc_html__( 'Button', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'button_style_divider',
				),

				array(
					'heading'          => esc_html__( 'Design', 'woodmart' ),
					'type'             => 'dropdown',
					'param_name'       => 'button_design',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Full width button', 'woodmart' ) => 'full',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				$button_typography['font_family'],
				$button_typography['font_size'],
				$button_typography['font_weight'],
				$button_typography['text_transform'],
				$button_typography['font_style'],
				$button_typography['line_height'],

				// Variable product.
				array(
					'title'      => esc_html__( 'Variable product', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'variable_product_style_divider',
				),

				array(
					'heading'          => esc_html__( 'Design', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'dropdown',
					'param_name'       => 'design',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Justify', 'woodmart' ) => 'justify',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Swatches layout', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'dropdown',
					'param_name'       => 'swatch_layout',
					'value'            => array(
						esc_html__( 'Default', 'woodmart' ) => 'default',
						esc_html__( 'Inline', 'woodmart' ) => 'inline',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Clear button position', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_select',
					'param_name'       => 'reset_button_position',
					'style'            => 'select',
					'selectors'        => array(),
					'devices'          => array(
						'desktop' => array(
							'value' => 'side',
						),
						'mobile'  => array(
							'value' => 'side',
						),
					),
					'value'            => array(
						esc_html__( 'Side', 'woodmart' ) => 'side',
						esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				array(
					'heading'          => esc_html__( 'Swatch label position', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_select',
					'param_name'       => 'label_position',
					'style'            => 'select',
					'selectors'        => array(),
					'devices'          => array(
						'desktop' => array(
							'value' => 'side',
						),
						'mobile'  => array(
							'value' => 'side',
						),
					),
					'value'            => array(
						esc_html__( 'Side', 'woodmart' ) => 'side',
						esc_html__( 'Top', 'woodmart' )  => 'top',
						esc_html__( 'Hide', 'woodmart' ) => 'hide',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Price.
				array(
					'title'      => esc_html__( 'Price', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'price_style_divider',
				),

				array(
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'woodmart_button_set',
					'param_name'       => 'price_style_tabs',
					'tabs'             => true,
					'value'            => array(
						esc_html__( 'Regular price', 'woodmart' ) => 'main_price',
						esc_html__( 'Old price', 'woodmart' )  => 'old_price',
						esc_html__( 'Suffix', 'woodmart' )     => 'suffix',
					),
					'default'          => 'main_price',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),

				$main_price_typography['font_family'],
				$main_price_typography['font_size'],
				$main_price_typography['font_weight'],
				$main_price_typography['text_transform'],
				$main_price_typography['font_style'],
				$main_price_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'main_price_text_color',
					'selectors'        => array(
						'{{WRAPPER}} .woocommerce-variation-price .price, {{WRAPPER}} .woocommerce-variation-price .amount, {{WRAPPER}} .woocommerce-variation-price del' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'price_style_tabs',
						'value'   => array( 'main_price' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				$old_price_typography['font_family'],
				$old_price_typography['font_size'],
				$old_price_typography['font_weight'],
				$old_price_typography['text_transform'],
				$old_price_typography['font_style'],
				$old_price_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'old_price_text_color',
					'selectors'        => array(
						'{{WRAPPER}} .woocommerce-variation-price .price del, {{WRAPPER}} .woocommerce-variation-price del .amount' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'price_style_tabs',
						'value'   => array( 'old_price' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				$suffix_typography['font_family'],
				$suffix_typography['font_size'],
				$suffix_typography['font_weight'],
				$suffix_typography['text_transform'],
				$suffix_typography['font_style'],
				$suffix_typography['line_height'],

				array(
					'heading'          => esc_html__( 'Text color', 'woodmart' ),
					'group'            => esc_html__( 'Style', 'woodmart' ),
					'type'             => 'wd_colorpicker',
					'param_name'       => 'suffix_text_color',
					'selectors'        => array(
						'{{WRAPPER}} .woocommerce-price-suffix' => array(
							'color: {{VALUE}};',
						),
					),
					'wd_dependency'    => array(
						'element' => 'price_style_tabs',
						'value'   => array( 'suffix' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				// Stock status.
				array(
					'title'      => esc_html__( 'Stock status', 'woodmart' ),
					'group'      => esc_html__( 'Style', 'woodmart' ),
					'type'       => 'woodmart_title_divider',
					'param_name' => 'stock_status_style_divider',
				),

				array(
					'heading'     => esc_html__( 'Enable stock status', 'woodmart' ),
					'group'       => esc_html__( 'Style', 'woodmart' ),
					'type'        => 'woodmart_switch',
					'param_name'  => 'enable_stock_status',
					'hint'        => esc_html__( 'If "NO" stock status will be removed.', 'woodmart' ),
					'true_state'  => 'yes',
					'false_state' => 'no',
					'default'     => 'yes',
				),

				// Design options.
				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),

				// Width option (with dependency Columns option, responsive).
				woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
				woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),
			),
		);
	}
}

add_filter( 'vc_autocomplete_woodmart_single_product_add_to_cart_product_id_callback', 'woodmart_productIdAutocompleteSuggester_new', 10, 1 );
add_filter( 'vc_autocomplete_woodmart_single_product_add_to_cart_product_id_render', 'woodmart_productIdAutocompleteRender', 10, 1 );
