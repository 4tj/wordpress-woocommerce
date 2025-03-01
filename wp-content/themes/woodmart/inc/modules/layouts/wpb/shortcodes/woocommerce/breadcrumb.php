<?php
/**
 * WooCommerce breadcrumb shortcode.
 *
 * @package Woodmart
 */

use XTS\Modules\Layouts\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_shortcode_woocommerce_breadcrumb' ) ) {
	/**
	 * WooCommerce breadcrumb shortcode.
	 *
	 * @param array $settings Shortcode attributes.
	 */
	function woodmart_shortcode_woocommerce_breadcrumb( $settings ) {
		$default_settings = array(
			'css'       => '',
			'alignment' => 'left',
			'nowrap_md' => 'no',
		);

		$settings = wp_parse_args( $settings, $default_settings );

		$wrapper_classes = apply_filters( 'vc_shortcodes_css_class', '', '', $settings );

		if ( $settings['css'] ) {
			$wrapper_classes .= ' ' . vc_shortcode_custom_css_class( $settings['css'] );
		}

		if ( 'yes' === $settings['nowrap_md'] ) {
			$wrapper_classes .= ' wd-nowrap-md';
		}

		$wrapper_classes .= ' text-' . woodmart_vc_get_control_data( $settings['alignment'], 'desktop' );

		ob_start();

		Main::setup_preview();

		if ( 'yes' === $settings['nowrap_md'] ) {
			woodmart_enqueue_inline_style( 'woo-el-breadcrumbs-builder' );
		}

		?>
		<div class="wd-el-breadcrumbs wd-wpb<?php echo esc_attr( $wrapper_classes ); ?>">
			<?php woodmart_current_breadcrumbs( 'shop' ); ?>
		</div>
		<?php

		Main::restore_preview();

		return ob_get_clean();
	}
}
