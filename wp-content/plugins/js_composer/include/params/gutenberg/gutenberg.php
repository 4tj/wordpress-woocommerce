<?php
/**
 * Param type "gutenberg".
 *
 * Used gutenberg editor as param type.
 *
 * @see https://kb.wpbakery.com/docs/inner-api/vc_map/#vc_map()-ParametersofparamsArray
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Gutenberg field param.
 *
 * @param array $settings
 * @param string $value
 *
 * @return string - html string.
 */
function vc_gutenberg_form_field( $settings, $value ) {
	$value = htmlspecialchars( $value );

	return '<div class="vc_gutenberg-field-wrapper"><button class="vc_btn vc_btn-grey vc_btn-sm" data-vc-action="open">Open Editor</button><div class="vc_gutenberg-modal-wrapper"></div><input name="' . $settings['param_name'] . '" class="wpb_vc_param_value vc_gutenberg-field vc_param-name-' . $settings['param_name'] . ' ' . $settings['type'] . '" type="hidden" value="' . $value . '"/></div>';
}
