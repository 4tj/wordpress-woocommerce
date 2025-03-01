<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}
/**
* ------------------------------------------------------------------------------------------------
* Images gallery element map
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_get_vc_map_gallery' ) ) {
	function woodmart_get_vc_map_gallery() {
		return array(
			'name'        => esc_html__( 'Images gallery', 'woodmart' ),
			'base'        => 'woodmart_gallery',
			'class'       => '',
			'category'    => function_exists( 'woodmart_get_tab_title_category_for_wpb' ) ? woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ) : esc_html__( 'Theme elements', 'woodmart' ),
			'description' => esc_html__( 'Images grid/carousel', 'woodmart' ),
			'icon'        => WOODMART_ASSETS . '/images/vc-icon/images-gallery.svg',
			'params'      => array(
				array(
					'param_name' => 'woodmart_css_id',
					'type'       => 'woodmart_css_id',
				),
				/**
				 * Images
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Images', 'woodmart' ),
					'param_name' => 'images_divider',
				),
				array(
					'type'             => 'attach_images',
					'heading'          => esc_html__( 'Images', 'woodmart' ),
					'param_name'       => 'images',
					'value'            => '',
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
						esc_html__( '0', 'woodmart' )      => '0',
						esc_html__( '5', 'woodmart' )      => '5',
						esc_html__( '8', 'woodmart' )      => '8',
						esc_html__( '12', 'woodmart' )     => '12',
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
				 * Layout
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Layout', 'woodmart' ),
					'param_name' => 'layout_divider',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'View', 'woodmart' ),
					'param_name'  => 'view',
					'save_always' => true,
					'value'       => array(
						esc_html__( 'Default grid', 'woodmart' ) => 'grid',
						esc_html__( 'Masonry grid', 'woodmart' ) => 'masonry',
						esc_html__( 'Carousel', 'woodmart' ) => 'carousel',
						esc_html__( 'Justified gallery', 'woodmart' ) => 'justified',
					),
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Space between images', 'woodmart' ),
					'param_name'       => 'spacing_tabs',
					'tabs'             => true,
					'value'            => array(
						esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
						esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
						esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
					),
					'dependency'       => array(
						'element'            => 'view',
						'value_not_equal_to' => array( 'justified' ),
					),
					'default'          => 'desktop',
					'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'spacing',
					'value'            => array(
						0,
						2,
						6,
						10,
						20,
						30,
					),
					'dependency'       => array(
						'element'            => 'view',
						'value_not_equal_to' => array( 'justified' ),
					),
					'wd_dependency'    => array(
						'element' => 'spacing_tabs',
						'value'   => array( 'desktop' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'spacing_tablet',
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						'0'  => '0',
						'2'  => '2',
						'6'  => '6',
						'10' => '10',
						'20' => '20',
						'30' => '30',
					),
					'std'              => '',
					'dependency'       => array(
						'element'            => 'view',
						'value_not_equal_to' => array( 'justified' ),
					),
					'wd_dependency'    => array(
						'element' => 'spacing_tabs',
						'value'   => array( 'tablet' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'spacing_mobile',
					'value'            => array(
						esc_html__( 'Inherit', 'woodmart' ) => '',
						'0'  => '0',
						'2'  => '2',
						'6'  => '6',
						'10' => '10',
						'20' => '20',
						'30' => '30',
					),
					'std'              => '',
					'dependency'       => array(
						'element'            => 'view',
						'value_not_equal_to' => array( 'justified' ),
					),
					'wd_dependency'    => array(
						'element' => 'spacing_tabs',
						'value'   => array( 'mobile' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'woodmart_button_set',
					'heading'          => esc_html__( 'Columns', 'woodmart' ),
					'hint'             => esc_html__( 'Number of columns in the grid.', 'woodmart' ),
					'param_name'       => 'columns_tabs',
					'tabs'             => true,
					'value'            => array(
						esc_html__( 'Desktop', 'woodmart' ) => 'desktop',
						esc_html__( 'Tablet', 'woodmart' ) => 'tablet',
						esc_html__( 'Mobile', 'woodmart' ) => 'mobile',
					),
					'dependency'       => array(
						'element' => 'view',
						'value'   => array( 'grid', 'masonry' ),
					),
					'default'          => 'desktop',
					'edit_field_class' => 'wd-res-control wd-custom-width vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'columns',
					'value'            => array(
						'1' => '1',
						'2' => '2',
						'3' => '3',
						'4' => '4',
						'5' => '5',
						'6' => '6',
					),
					'std'              => '3',
					'dependency'       => array(
						'element' => 'view',
						'value'   => array( 'grid', 'masonry' ),
					),
					'wd_dependency'    => array(
						'element' => 'columns_tabs',
						'value'   => array( 'desktop' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'columns_tablet',
					'value'            => array(
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						'1'                              => '1',
						'2'                              => '2',
						'3'                              => '3',
						'4'                              => '4',
						'5'                              => '5',
						'6'                              => '6',
					),
					'std'              => 'auto',
					'dependency'       => array(
						'element' => 'view',
						'value'   => array( 'grid', 'masonry' ),
					),
					'wd_dependency'    => array(
						'element' => 'columns_tabs',
						'value'   => array( 'tablet' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'             => 'dropdown',
					'param_name'       => 'columns_mobile',
					'value'            => array(
						esc_html__( 'Auto', 'woodmart' ) => 'auto',
						'1'                              => '1',
						'2'                              => '2',
						'3'                              => '3',
						'4'                              => '4',
						'5'                              => '5',
						'6'                              => '6',
					),
					'std'              => 'auto',
					'dependency'       => array(
						'element' => 'view',
						'value'   => array( 'grid', 'masonry' ),
					),
					'wd_dependency'    => array(
						'element' => 'columns_tabs',
						'value'   => array( 'mobile' ),
					),
					'edit_field_class' => 'wd-res-item vc_col-sm-12 vc_column',
				),
				array(
					'type'       => 'woodmart_empty_space',
					'param_name' => 'woodmart_empty_space',
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Horizontal  align', 'woodmart' ),
					'param_name'       => 'horizontal_align',
					'value'            => array(
						esc_html__( 'Left', 'woodmart' )   => 'left',
						esc_html__( 'Center', 'woodmart' ) => 'center',
						esc_html__( 'Right', 'woodmart' )  => 'right',
					),
					'images_value'     => array(
						'left'   => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/left.png',
						'center' => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/center.png',
						'right'  => WOODMART_ASSETS_IMAGES . '/settings/content-align/horizontal/right.png',
					),
					'std'              => 'center',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column content-position',
					'dependency'       => array(
						'element' => 'view',
						'value'   => array( 'grid', 'masonry', 'carousel' ),
					),
				),
				array(
					'type'             => 'woodmart_image_select',
					'heading'          => esc_html__( 'Vertical align', 'woodmart' ),
					'param_name'       => 'vertical_align',
					'value'            => array(
						esc_html__( 'Top', 'woodmart' )    => 'top',
						esc_html__( 'Middle', 'woodmart' ) => 'middle',
						esc_html__( 'Bottom', 'woodmart' ) => 'bottom',
					),
					'images_value'     => array(
						'top'    => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/top.png',
						'middle' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/middle.png',
						'bottom' => WOODMART_ASSETS_IMAGES . '/settings/content-align/vertical/bottom.png',
					),
					'std'              => 'middle',
					'wood_tooltip'     => true,
					'edit_field_class' => 'vc_col-sm-6 vc_column content-position',
					'dependency'       => array(
						'element' => 'view',
						'value'   => array( 'grid', 'masonry', 'carousel' ),
					),
				),
				/**
				 * Carousel
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Carousel', 'woodmart' ),
					'group'      => esc_html__( 'Carousel', 'woodmart' ),
					'param_name' => 'carousel_divider',
					'dependency' => array(
						'element' => 'view',
						'value'   => array( 'carousel' ),
					),
				),
				/**
				 * Click action
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Click action', 'woodmart' ),
					'param_name' => 'click_divider',
				),
				array(
					'type'             => 'dropdown',
					'heading'          => esc_html__( 'On click action', 'woodmart' ),
					'param_name'       => 'on_click',
					'value'            => array(
						esc_html__( 'Lightbox', 'woodmart' ) => 'lightbox',
						esc_html__( 'Custom link', 'woodmart' ) => 'links',
						esc_html__( 'None', 'woodmart' ) => 'none',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Open in new tab', 'woodmart' ),
					'param_name'       => 'target_blank',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 0,
					'dependency'       => array(
						'element' => 'on_click',
						'value'   => array( 'links' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Images captions', 'woodmart' ),
					'hint'             => esc_html__( 'Display images captions below the images when you open them in lightbox. Captions are based on titles of your photos and can be edited in Dashboard -> Media.', 'woodmart' ),
					'param_name'       => 'caption',
					'true_state'       => 1,
					'false_state'      => 0,
					'default'          => 0,
					'dependency'       => array(
						'element' => 'on_click',
						'value'   => array( 'lightbox' ),
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'       => 'exploded_textarea_safe',
					'heading'    => esc_html__( 'Custom links', 'woodmart' ),
					'param_name' => 'custom_links',
					'hint'       => esc_html__( 'Enter links for each slide (Note: divide links with linebreaks (Enter)).', 'woodmart' ),
					'dependency' => array(
						'element' => 'on_click',
						'value'   => array( 'links' ),
					),
				),
				/**
				 * Extra
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Extra options', 'woodmart' ),
					'param_name' => 'extra_divider',
				),
				array(
					'type'             => 'woodmart_switch',
					'heading'          => esc_html__( 'Lazy loading for images', 'woodmart' ),
					'hint'             => esc_html__( 'Enable lazy loading for images for this element.', 'woodmart' ),
					'param_name'       => 'lazy_loading',
					'true_state'       => 'yes',
					'false_state'      => 'no',
					'default'          => 'no',
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',

				function_exists( 'woodmart_get_vc_animation_map' ) ? woodmart_get_vc_animation_map( 'wd_animation' ) : '',
				function_exists( 'woodmart_get_vc_animation_map' ) ? woodmart_get_vc_animation_map( 'wd_animation_delay' ) : '',
				function_exists( 'woodmart_get_vc_animation_map' ) ? woodmart_get_vc_animation_map( 'wd_animation_duration' ) : '',

				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
				array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'param_name' => 'css',
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
				),
				function_exists( 'woodmart_get_vc_responsive_spacing_map' ) ? woodmart_get_vc_responsive_spacing_map() : '',

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
