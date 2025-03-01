<?php if ( ! defined( 'WOODMART_THEME_DIR' ) ) exit( 'No direct script access allowed' );

/**
* ------------------------------------------------------------------------------------------------
* Extra menu (part of the mega menu)
* ------------------------------------------------------------------------------------------------
*/

if( ! function_exists( 'woodmart_shortcode_extra_menu' ) ) {
	function woodmart_shortcode_extra_menu($atts = array(), $content = null) {
		$output = $class = $liclass = $label_out = '';
		extract(shortcode_atts( array(
			'link'          => '',
			'title'         => '',
			'label'         => 'primary',
			'label_text'    => '',
			'image'         => '',
			'image_size'    => '',
			'css_animation' => 'none',
			'el_class'      => '',
			'css'           => '',
		), $atts ));

		if ( woodmart_get_menu_label_tag( $label, $label_text ) ) {
			$liclass .= woodmart_get_menu_label_class( $label );
		}

		if ( $el_class ) {
			$class .= ' ' . $el_class;
		}
		$class .= apply_filters( 'vc_shortcodes_css_class', '', '', $atts );
		$class .= ' mega-menu-list wd-sub-accented wd-wpb';
		$class .= woodmart_get_css_animation( $css_animation );
		$class .= woodmart_get_old_classes( ' sub-menu' );

		if ( $css ) {
			$class .= ' ' . vc_shortcode_custom_css_class( $css );
		}

		// Image settings.
		$image_output = '';
		if ( $image ) {
			$image_output = woodmart_otf_get_image_html( $image, $image_size, array(), array( 'class' => 'wd-nav-img' ) );
		}

		ob_start();

		woodmart_enqueue_inline_style( 'mod-nav-menu-label' );
		?>

			<ul class="wd-sub-menu<?php echo esc_attr( $class ); ?>" >
				<li class="<?php echo esc_attr( $liclass ); ?>">
					<a <?php echo woodmart_get_link_attributes( $link ); ?>>
						<?php if ( $image_output ) : ?>
							<?php echo $image_output; ?>
						<?php endif; ?>

						<span class="nav-link-text">
							<?php echo wp_kses( vc_value_from_safe( $title ), woodmart_get_allowed_html() ); ?>
						</span>
						<?php echo woodmart_get_menu_label_tag( $label, $label_text ); ?>
					</a>
					<ul class="sub-sub-menu">
						<?php echo do_shortcode( $content ); ?>
					</ul>
				</li>
			</ul>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}


if( ! function_exists( 'woodmart_shortcode_extra_menu_list' ) ) {
	function woodmart_shortcode_extra_menu_list($atts, $content) {
		$output = $class = $label_out = '';
		extract(shortcode_atts( array(
			'link' => '',
			'title' => '',
			'image' => '',
			'image_size' => '',
			'label' => 'primary',
			'label_text' => '',
			'el_class' => ''
		), $atts ));

		if ( woodmart_get_menu_label_tag( $label, $label_text ) ) {
			$class .= woodmart_get_menu_label_class( $label );
		}

		if ( $el_class ) {
			$class .= ' ' . $el_class;
		}

		// Image settings.
		$image_output = '';
		if ( $image ) {
			$image_output = woodmart_otf_get_image_html( $image, $image_size, array(), array( 'class' => 'wd-nav-img' ) );
		}

		ob_start();
		?>

		<li class="<?php echo esc_attr( $class ); ?>">
			<a <?php echo woodmart_get_link_attributes( $link ); ?>>
				<?php if ( $image_output ) : ?>
					<?php echo $image_output; ?>
				<?php endif; ?>

				<?php echo wp_kses( vc_value_from_safe( $title ), woodmart_get_allowed_html() ); ?>
				<?php echo woodmart_get_menu_label_tag( $label, $label_text ); ?>
			</a>
		</li>

		<?php
		$output = ob_get_contents();
		ob_end_clean();

		return $output;
	}
}

if( ! function_exists( 'woodmart_get_menu_label_tag' ) ) {
	function woodmart_get_menu_label_tag( $label, $label_text ) {
		if ( empty( $label_text ) ) {
			return '';
		}

		return '<span class="menu-label menu-label-' . $label . '">' . esc_attr( $label_text ) . '</span>';
	}
}


if( ! function_exists( 'woodmart_get_menu_label_class' ) ) {
	function woodmart_get_menu_label_class( $label ) {
		$class = '';
		$class .= ' item-with-label';
		$class .= ' item-label-' . $label;
		return $class;
	}
}

