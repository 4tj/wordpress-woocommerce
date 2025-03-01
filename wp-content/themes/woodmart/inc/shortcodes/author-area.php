<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Widget with author info
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_author_area' ) ) {
	function woodmart_shortcode_author_area($atts, $content) {
		$output = $class = '';
		extract( shortcode_atts( array(
			'title' => '',
			'author_name' => '',
			'image' => '',
			'img_size' => '800x600',
			'link' => '',
			'link_text' => '',
			'alignment' => 'left',
			'style' => '',
			'woodmart_color_scheme' => 'dark',
			'css_animation' => 'none',
			'el_class' => '',
			'woodmart_css_id' => '',
			'css' => '',
		), $atts ) );

		$img_id = preg_replace( '/[^\d]/', '', $image );

		if ( $img_id ) {
			$image_output = woodmart_otf_get_image_html( $img_id, $img_size, array(), array( 'class' => 'author-area-image' ) );

			if ( woodmart_is_svg( wp_get_attachment_image_url( $img_id ) ) ) {
				$image_output = woodmart_get_svg_html( $img_id, $img_size );
			}
		}

		$class .= ' text-' . $alignment;
		$class .= ' color-scheme-' . $woodmart_color_scheme;
		$class .= woodmart_get_css_animation( $css_animation );
		$class .= ' ' . $el_class;
		$class .= ' wd-rs-' . $woodmart_css_id;

		if ( function_exists( 'vc_shortcode_custom_css_class' ) ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		if ( ! str_contains( $link, 'url:' ) ) {
			$link = 'url:' . rawurlencode( $link );
		}

		ob_start(); ?>

			<div class="author-area wd-set-mb reset-last-child<?php echo esc_attr( $class ); ?>">

				<?php if ( $title ) : ?>
					<h3 class="title author-title">
						<?php echo esc_html( $title ); ?>
					</h3>
				<?php endif ?>

				<?php if ( isset( $image_output ) ) : ?>
					<div class="author-avatar">
						<?php echo $image_output; //phpcs:ignore. ?>
					</div>
				<?php endif; ?>

				<?php if ( $author_name ) : ?>
					<h4 class="title author-name">
						<?php echo esc_html( $author_name ); ?>
					</h4>
				<?php endif ?>

				<?php if ( $content ) : ?>
					<div class="author-area-info">
						<?php echo do_shortcode( $content ); ?>
					</div>
				<?php endif ?>

				<?php if ( ! empty( $link_text ) ) : ?>
					<a <?php echo woodmart_get_link_attributes( $link ); ?> class="btn">
						<?php echo esc_html( $link_text ); ?>
					</a>
				<?php endif; ?>

			</div>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}
