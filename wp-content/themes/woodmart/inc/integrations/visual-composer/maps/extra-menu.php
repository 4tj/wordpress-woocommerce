<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) {
	exit( 'No direct script access allowed' );}
/**
* ------------------------------------------------------------------------------------------------
* Extra menu list element map
* ------------------------------------------------------------------------------------------------
*/

if ( ! function_exists( 'woodmart_get_vc_map_extra_menu' ) ) {
	function woodmart_get_vc_map_extra_menu() {
		return array(
			'name'                    => esc_html__( 'Extra menu list', 'woodmart' ),
			'base'                    => 'extra_menu',
			'as_parent'               => array( 'only' => 'extra_menu_list' ),
			'content_element'         => true,
			'show_settings_on_create' => true,
			'category'                => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description'             => esc_html__( 'Create a menu list for your mega menu dropdown', 'woodmart' ),
			'icon'                    => WOODMART_ASSETS . '/images/vc-icon/extra-menu-list.svg',
			'params'                  => array(
				array(
					'type'       => 'woodmart_css_id',
					'param_name' => 'woodmart_css_id',
				),
				/**
				 * Link
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Link', 'woodmart' ),
					'param_name' => 'link_divider',
				),
				array(
					'type'             => 'textfield',
					'holder'           => 'div',
					'heading'          => esc_html__( 'Title', 'woodmart' ),
					'param_name'       => 'title',
					'edit_field_class' => 'vc_col-sm-6 vc_column',

				),
				array(
					'type'             => 'vc_link',
					'heading'          => esc_html__( 'Link', 'woodmart' ),
					'param_name'       => 'link',
					'hint'             => esc_html__( 'Enter URL if you want this parent menu item to have a link.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Label
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Label', 'woodmart' ),
					'param_name' => 'label_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Label text (optional)', 'woodmart' ),
					'param_name'       => 'label_text',
					'hint'             => esc_html__( 'Write a label for this menu item badge like “Sale”, “Hot”, “New” etc. Leave empty to not add any badges.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Label color', 'woodmart' ),
					'param_name'       => 'label',
					'value'            => array(
						esc_html__( 'Primary Color', 'woodmart' ) => 'primary',
						esc_html__( 'Secondary', 'woodmart' ) => 'secondary',
						esc_html__( 'Red', 'woodmart' ) => 'red',
						esc_html__( 'Green', 'woodmart' ) => 'green',
						esc_html__( 'Blue', 'woodmart' ) => 'blue',
						esc_html__( 'Orange', 'woodmart' ) => 'orange',
						esc_html__( 'Grey', 'woodmart' ) => 'grey',
						esc_html__( 'White', 'woodmart' ) => 'white',
						esc_html__( 'Black', 'woodmart' ) => 'black',
					),
					'style'            => array(
						'primary'   => woodmart_get_color_value( 'primary-color', '#7eb934' ),
						'secondary' => woodmart_get_color_value( 'secondary-color', '#fbbc34' ),
						'red'       => '#D41212',
						'green'     => '#65B32E',
						'blue'      => '#00A1BE',
						'orange'    => '#fbbc34',
						'grey'      => '#ECECEC',
						'black'     => '#000000',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Image
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'image_divider',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'param_name'       => 'image_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
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
				( function_exists( 'vc_map_add_css_animation' ) ) ? vc_map_add_css_animation( true ) : '',
				array(
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
				// Design options.
				array(
					'heading'    => esc_html__( 'CSS box', 'woodmart' ),
					'group'      => esc_html__( 'Design Options', 'js_composer' ),
					'type'       => 'css_editor',
					'param_name' => 'css',
				),
				woodmart_get_vc_responsive_spacing_map(),
			),
			'js_view'                 => 'VcColumnView',
		);
	}
}

if ( ! function_exists( 'woodmart_get_vc_map_extra_menu_list' ) ) {
	function woodmart_get_vc_map_extra_menu_list() {
		return array(
			'name'            => esc_html__( 'Extra menu list item', 'woodmart' ),
			'base'            => 'extra_menu_list',
			'as_child'        => array( 'only' => 'extra_menu' ),
			'content_element' => true,
			'category'        => woodmart_get_tab_title_category_for_wpb( esc_html__( 'Theme elements', 'woodmart' ) ),
			'description'     => esc_html__( 'A link for your extra menu list', 'woodmart' ),
			'icon'            => WOODMART_ASSETS . '/images/vc-icon/extra-menu-list-item.svg',
			'params'          => array(
				/**
				 * Link
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Link', 'woodmart' ),
					'param_name' => 'link_divider',
				),
				array(
					'type'             => 'textfield',
					'holder'           => 'div',
					'heading'          => esc_html__( 'Title', 'woodmart' ),
					'param_name'       => 'title',
					'edit_field_class' => 'vc_col-sm-6 vc_column',

				),
				array(
					'type'             => 'vc_link',
					'heading'          => esc_html__( 'Link', 'woodmart' ),
					'param_name'       => 'link',
					'hint'             => esc_html__( 'Enter URL if you want this parent menu item to have a link.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Label
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Label', 'woodmart' ),
					'param_name' => 'label_divider',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Label text (optional)', 'woodmart' ),
					'param_name'       => 'label_text',
					'hint'             => esc_html__( 'Write a label for this menu item badge like “Sale”, “Hot”, “New” etc. Leave empty to not add any badges.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'woodmart_dropdown',
					'heading'          => esc_html__( 'Label color', 'woodmart' ),
					'param_name'       => 'label',
					'value'            => array(
						esc_html__( 'Primary Color', 'woodmart' ) => 'primary',
						esc_html__( 'Secondary', 'woodmart' ) => 'secondary',
						esc_html__( 'Red', 'woodmart' ) => 'red',
						esc_html__( 'Green', 'woodmart' ) => 'green',
						esc_html__( 'Blue', 'woodmart' ) => 'blue',
						esc_html__( 'Orange', 'woodmart' ) => 'orange',
						esc_html__( 'Grey', 'woodmart' ) => 'grey',
						esc_html__( 'White', 'woodmart' ) => 'white',
						esc_html__( 'Black', 'woodmart' ) => 'black',
					),
					'style'            => array(
						'primary'   => woodmart_get_color_value( 'primary-color', '#7eb934' ),
						'secondary' => woodmart_get_color_value( 'secondary-color', '#fbbc34' ),
						'red'       => '#D41212',
						'green'     => '#65B32E',
						'blue'      => '#00A1BE',
						'orange'    => '#fbbc34',
						'grey'      => '#ECECEC',
						'black'     => '#000000',
					),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				/**
				 * Image
				 */
				array(
					'type'       => 'woodmart_title_divider',
					'holder'     => 'div',
					'title'      => esc_html__( 'Image', 'woodmart' ),
					'param_name' => 'image_divider',
				),
				array(
					'type'             => 'attach_image',
					'heading'          => esc_html__( 'Image', 'woodmart' ),
					'param_name'       => 'image',
					'value'            => '',
					'hint'             => esc_html__( 'Select image from media library.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
				),
				array(
					'type'             => 'textfield',
					'heading'          => esc_html__( 'Image size', 'woodmart' ),
					'param_name'       => 'image_size',
					'hint'             => esc_html__( 'Enter image size. Example: \'thumbnail\', \'medium\', \'large\', \'full\' or other sizes defined by current theme. Alternatively enter image size in pixels: 200x100 (Width x Height). Leave empty to use \'thumbnail\' size.', 'woodmart' ),
					'edit_field_class' => 'vc_col-sm-6 vc_column',
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
					'type'       => 'textfield',
					'heading'    => esc_html__( 'Extra class name', 'woodmart' ),
					'param_name' => 'el_class',
					'hint'       => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
			),
		);
	}
}

if ( class_exists( 'WPBakeryShortCodesContainer' ) ) {
	class WPBakeryShortCode_extra_menu extends WPBakeryShortCodesContainer {

	}
}

// Replace Wbc_Inner_Item with your base name from mapping for nested element
if ( class_exists( 'WPBakeryShortCode' ) ) {
	class WPBakeryShortCode_extra_menu_list extends WPBakeryShortCode {

	}
}
