<?php

namespace XTS\Modules\Layouts;

use Elementor\Plugin;
use XTS\Gutenberg\Blocks_Assets;
use XTS\Gutenberg\Post_CSS;
use XTS\Singleton;

abstract class Layout_Type extends Singleton {
	/**
	 * Constructor.
	 */
	public function init() {
		add_filter( 'template_include', array( $this, 'override_template' ), 20 );
	}

	/**
	 * Check.
	 *
	 * @param array  $condition Condition.
	 * @param string $type      Layout type.
	 */
	public function check( $condition, $type = '' ) {
	}

	/**
	 * Override templates.
	 *
	 * @param string $template Template.
	 */
	public function override_template( $template ) {
	}

	/**
	 * Display template.
	 */
	private function display_template() {
	}

	/**
	 * Before template content.
	 */
	public function before_template_content() {
		get_header();
		do_action( 'woocommerce_before_main_content' );
	}

	/**
	 * After template content.
	 */
	public function after_template_content() {
		do_action( 'woocommerce_after_main_content' );
		get_footer();
	}

	/**
	 * Template content.
	 *
	 * @param string $type Template type.
	 */
	public function template_content( $type ) {
		$id   = apply_filters( 'wpml_object_id', Main::get_instance()->get_layout_id( $type ), 'woodmart_layout' );
		$post = get_post( $id );

		if ( ! $post || 'woodmart_layout' !== $post->post_type || ! $id ) {
			return;
		}

		if ( woodmart_is_elementor_installed() && Plugin::$instance->documents->get( $id )->is_built_with_elementor() ) {
			$content = woodmart_elementor_get_content( $id );
		} elseif ( has_blocks( $post->post_content ) ) {
			$content = '';
			if ( woodmart_get_opt( 'gutenberg_blocks' ) ) {
				$content  = Blocks_Assets::get_instance()->get_inline_scripts( $id );
				$content .= Post_CSS::get_instance()->get_inline_blocks_css( $id );
			}

			$content .= do_shortcode( do_blocks( $post->post_content ) );
		} else {
			$shortcodes_custom_css          = get_post_meta( $id, '_wpb_shortcodes_custom_css', true );
			$woodmart_shortcodes_custom_css = get_post_meta( $id, 'woodmart_shortcodes_custom_css', true );

			$content = '<style data-type="vc_shortcodes-custom-css">';
			if ( ! empty( $shortcodes_custom_css ) ) {
				$content .= $shortcodes_custom_css;
			}

			if ( ! empty( $woodmart_shortcodes_custom_css ) ) {
				$content .= $woodmart_shortcodes_custom_css;
			}
			$content .= '</style>';

			if ( function_exists( 'vc_modules_manager' ) && vc_modules_manager()->is_module_on( 'vc-custom-css' ) ) {
				ob_start();

				vc_modules_manager()->get_module( 'vc-custom-css' )->output_custom_css_to_page( $id );

				$content .= ob_get_clean();
			}

			$content .= do_shortcode( apply_filters( 'the_content', $post->post_content ) );
		}

		echo $content; // phpcs:ignore
	}
}

