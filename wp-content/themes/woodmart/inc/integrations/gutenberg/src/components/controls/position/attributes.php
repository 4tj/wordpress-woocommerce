<?php

use XTS\Gutenberg\Block_Attributes;

if ( ! function_exists( 'wd_get_position_control_attrs' ) ) {
	function wd_get_position_control_attrs( $attrs_prefix = '' ) {
		$attr = new Block_Attributes();

		$attr->add_attr(
			array(
				'type'   => array(
					'type'       => 'string',
					'default'    => '',
					'responsive' => true,
				),
				'zIndex' => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'top'    => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'right'  => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'bottom' => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'left'   => array(
					'type'       => 'string',
					'responsive' => true,
				),
				'lock'   => array(
					'type'       => 'boolean',
					'default'    => false,
					'responsive' => true,
				),
				'units'  => array(
					'type'       => 'string',
					'default'    => 'px',
					'responsive' => true,
				),
			),
			$attrs_prefix
		);

		return $attr->get_attr();
	}
}
