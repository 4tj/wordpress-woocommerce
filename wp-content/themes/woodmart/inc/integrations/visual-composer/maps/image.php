<?php

if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );
}

if ( ! function_exists( 'woodmart_get_vc_map_image' ) ) {
	function woodmart_get_vc_map_image() {
		return array(
			'name'        => esc_html__( 'Image or SVG', 'woodmart' ),
			'base'        => 'woodmart_image',
			'category'    => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/image-or-svg.svg',
			'description' => esc_html__( 'Display JPG, PNG or SVG image', 'woodmart' ),
			'params'      => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),

				/**
				 * Image Option Section.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'param_name'       => 'img_id',
					'hint'             => esc_html__( 'Select images from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'param_name'       => 'img_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Image alignment', 'woodmart' ),
					'param_name'       => 'img_align',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'center' => WOODMART_ASSETS_IMAGES . '/settings/align/center.jpg',
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/align/left.jpg',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/align/right.jpg',
					),
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column title-align',
				),
				array(
					'heading'       => esc_html__( 'Rounding', 'woodmart' ),
					'type'          => 'wd_select',
					'param_name'    => 'rounding_size',
					'style'         => 'select',
					'selectors'     => array(
						'{{WRAPPER}}' => array(
							'--wd-brd-radius: {{VALUE}}px;',
						),
					),
					'devices'       => array(
						'desktop' => array(
							'value' => '',
						),
					),
					'value'         => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						esc_html__( '0', 'woodmart' )  => '0',
						esc_html__( '5', 'woodmart' )  => '5',
						esc_html__( '8', 'woodmart' )  => '8',
						esc_html__( '12', 'woodmart' ) => '12',
						esc_html__( 'Custom', 'woodmart' ) => 'custom',
					),
					'generate_zero' => true,
				),
				array(
					'heading'       => esc_html__( 'Custom rounding', 'woodmart' ),
					'type'          => 'wd_slider',
					'param_name'    => 'custom_rounding_size',
					'selectors'     => array(
						'{{WRAPPER}}' => array(
							'--wd-brd-radius: {{VALUE}}{{UNIT}};',
						),
					),
					'devices'       => array(
						'desktop' => array(
							'value' => '',
							'unit'  => 'px',
						),
					),
					'range'         => array(
						'px' => array(
							'min'  => 0,
							'max'  => 300,
							'step' => 1,
						),
						'%'  => array(
							'min'  => 0,
							'max'  => 100,
							'step' => 1,
						),
					),
					'dependency'    => array(
						'element' => 'rounding_size',
						'value'   => function_exists( 'woodmart_compress' ) ? woodmart_compress(
							wp_json_encode(
								array(
									'devices' => array(
										'desktop' => array(
											'value' => 'custom',
										),
									),
								)
							)
						) : '',
					),
					'generate_zero' => true,
				),
				/**
				 * Extra Option Section.
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'On click action', 'woodmart' ),
					'param_name'       => 'click_action',
					'value'            => array(
						esc_html__( 'None', 'woodmart' ) => 'none',
						esc_html__( 'Lightbox', 'woodmart' ) => 'lightbox',
						esc_html__( 'Custom link', 'woodmart' ) => 'custom_link',
					),
					'hint'             => esc_html__( 'Select action for click action.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Link', 'woodmart' ),
					'param_name' => 'img_link',
					'hint'       => esc_html__( 'Enter URL if you want this image to have a link.', 'woodmart' ),
					'dependency' => array(
						'element' => 'click_action',
						'value'   => 'custom_link',
					),
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Open in new tab', 'woodmart' ),
					'param_name'       => 'img_link_blank',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'dependency'       => array(
						'element' => 'click_action',
						'value'   => 'custom_link',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),

				woodmart_get_vc_animation_map( 'wd_animation' ),
				woodmart_get_vc_animation_map( 'wd_animation_delay' ),
				woodmart_get_vc_animation_map( 'wd_animation_duration' ),

				woodmart_parallax_scroll_map( 'parallax_scroll' ),
				woodmart_parallax_scroll_map( 'scroll_x' ),
				woodmart_parallax_scroll_map( 'scroll_y' ),
				woodmart_parallax_scroll_map( 'scroll_z' ),
				woodmart_parallax_scroll_map( 'scroll_smooth' ),

				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'extra_classes',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),

				/**
				 * Design Option Tab.
				 */
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				woodmart_get_vc_responsive_spacing_map(),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Box Shadow', 'woodmart' ),
					'param_name'       => 'woodmart_box_shadow',
					'group'            => esc_html__( 'Design Options', 'js_composer' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'wd_box_shadow',
					'param_name'       => 'wd_box_shadow',
					'group'            => esc_html__( 'Design Options', 'js_composer' ),
					'selectors'        => array(
						'{{WRAPPER}}' => array(
							'box-shadow: {{HORIZONTAL}}px {{VERTICAL}}px {{BLUR}}px {{SPREAD}}px {{COLOR}};',
						),
					),
					'edit_field_class' => 'vc_col-sm-12 vc_column',
					'dependency'       => array(
						'element' => 'woodmart_box_shadow',
						'value'   => array( 'yes' ),
					),
					'default'          => array(
						'horizontal' => '0',
						'vertical'   => '0',
						'blur'       => '9',
						'spread'     => '0',
						'color'      => 'rgba(0, 0, 0, .15)',
					),
				),

				/**
				 * Advanced Tab.
				 */
				woodmart_get_vc_responsive_visible_map( 'responsive_tabs_hide' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_desktop' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_tablet' ),
				woodmart_get_vc_responsive_visible_map( 'wd_hide_on_mobile' ),

				// Width option (with dependency Columns option, responsive).
				woodmart_get_responsive_dependency_width_map( 'responsive_tabs' ),
				woodmart_get_responsive_dependency_width_map( 'width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_desktop' ),
				woodmart_get_responsive_dependency_width_map( 'width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_tablet' ),
				woodmart_get_responsive_dependency_width_map( 'width_mobile' ),
				woodmart_get_responsive_dependency_width_map( 'custom_width_mobile' ),

				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Display inline (Deprecated)', 'woodmart' ),
					'hint'             => esc_html__( 'This option is deprecated. You can use the "Width" option by selecting "Inline (auto)" to achieve the same result.', 'woodmart' ),
					'param_name'       => 'display_inline',
					'group'            => esc_html__( 'Advanced', 'woodmart' ),
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-12 vc_column',
				),
			),
		);
	}
}
