<?php

namespace XTS\Modules\Header_Builder\Elements;

use XTS\Modules\Header_Builder\Element;

/**
 * ------------------------------------------------------------------------------------------------
 * Simple vertical line
 * ------------------------------------------------------------------------------------------------
 */
class Divider extends Element {

	public function __construct() {
		parent::__construct();

		$this->template_name = 'divider';
	}

	public function map() {
		$this->args = array(
			'type'            => 'divider',
			'title'           => esc_html__( 'Divider', 'woodmart' ),
			'text'            => esc_html__( 'Simple vertical line', 'woodmart' ),
			'icon'            => 'xts-i-divider',
			'editable'        => true,
			'container'       => false,
			'edit_on_create'  => true,
			'drag_target_for' => array(),
			'drag_source'     => 'content_element',
			'removable'       => true,
			'addable'         => true,
			'params'          => array(
				'color'       => array(
					'id'        => 'color',
					'title'     => esc_html__( 'Color', 'woodmart' ),
					'tab'       => esc_html__( 'Style', 'woodmart' ),
					'type'      => 'color',
					'value'     => '',
					'selectors' => array(
						'{{WRAPPER}}' => array(
							'--wd-divider-color: {{VALUE}};',
						),
					),
				),
				'full_height' => array(
					'id'          => 'full_height',
					'title'       => esc_html__( 'Full height', 'woodmart' ),
					'hint'        => '<video src="' . WOODMART_TOOLTIP_URL . 'hb_divider_full_height.mp4" autoplay loop muted></video>',
					'type'        => 'switcher',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'value'       => false,
					'description' => esc_html__( 'Mark this option if you want to show this divider line on the full height for this row.', 'woodmart' ),
				),
				'css_class'   => array(
					'id'          => 'css_class',
					'title'       => esc_html__( 'Additional CSS class', 'woodmart' ),
					'type'        => 'text',
					'tab'         => esc_html__( 'Style', 'woodmart' ),
					'value'       => '',
					'description' => esc_html__( 'If you wish to style particular content element differently, then use this field to add a class name and then refer to it in your css file.', 'woodmart' ),
				),
			),
		);
	}

	public function has_border( $params ) {
		return( isset( $params['border'] ) && isset( $params['border']['width'] ) && (int) $params['border']['width'] > 1 );
	}
}
