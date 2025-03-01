<?php
/**
 * Products template function
 *
 * @package xts
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Direct access not allowed.
}

if ( ! function_exists( 'woodmart_elementor_products_tabs_template' ) ) {
	function woodmart_elementor_products_tabs_template( $settings ) {
		$default_settings = [
			// General.
			'title'                         => '',
			'description'                   => '',
			'image'                         => '',
			'image_custom_dimension'        => '',
			'design'                        => 'default',
			'alignment'                     => 'center',
			'tabs_items'                    => [],
			'title_text_color_scheme'       => 'inherit',
			'tabs_style'                    => 'underline',
			'icon_alignment'                => 'left',
			'icon_alignment_design_default' => 'center',
			'enable_heading_bg'             => 'no',

			// Layout.
			'layout'                        => 'grid',
			'pagination'                    => '',
			'pagination_arrows_position'    => '',
			'items_per_page'                => 12,
			'spacing'                       => woodmart_get_opt( 'products_spacing' ),
			'spacing_tablet'                => woodmart_get_opt( 'products_spacing_tablet' ),
			'spacing_mobile'                => woodmart_get_opt( 'products_spacing_mobile' ),
			'columns'                       => [ 'size' => 4 ],
			'products_masonry'              => woodmart_get_opt( 'products_masonry' ),
			'products_different_sizes'      => woodmart_get_opt( 'products_different_sizes' ),
			'product_quantity'              => woodmart_get_opt( 'product_quantity' ),

			// Design.
			'product_hover'                 => woodmart_get_opt( 'products_hover' ),
			'sale_countdown'                => 0,
			'stretch_product_desktop'       => 0,
			'stretch_product_tablet'        => 0,
			'stretch_product_mobile'        => 0,
			'stock_progress_bar'            => 0,
			'highlighted_products'          => 0,
			'products_divider'              => 0,
			'products_bordered_grid'        => 0,
			'products_bordered_grid_style'  => 'outside',
			'products_with_background'      => 0,
			'products_shadow'               => 0,
			'products_color_scheme'         => 'default',
			'img_size'                      => 'woocommerce_thumbnail',

			// Extra.
			'elementor'                => true,
		];

		$settings = wp_parse_args( $settings, $default_settings );

		if ( empty( $settings['spacing'] ) && '0' !== $settings['spacing'] && 0 !== $settings['spacing'] ) {
			$settings['spacing'] = woodmart_get_opt( 'products_spacing' );
		}

		$image_output    = '';
		$wrapper_classes = '';
		$header_classes  = '';
		$title_classes   = '';
		$wd_nav_classes  = '';

		// Title classes.
		if ( woodmart_elementor_is_edit_mode() ) {
			$title_classes .= ' elementor-inline-editing';
		}

		// Header classes.
		$settings['alignment'] = $settings['alignment'] ? $settings['alignment'] : 'center';
		$header_classes .= ' text-' . $settings['alignment'];

		// Wrapper classes.
		$wrapper_classes .= ' tabs-design-' . $settings['design'];

		if ( 'yes' === $settings['enable_heading_bg'] ) {
			$wrapper_classes .= ' wd-header-with-bg';
		}

		if ( 'simple' === $settings['design'] ) {
			$settings['tabs_style'] = 'default';

			if ( 'grid' === $settings['layout'] && empty( $settings['pagination_arrows_position'] ) ) {
				$settings['pagination_arrows_position'] = 'together';
			} elseif ( 'carousel' === $settings['layout'] && empty( $settings['carousel_arrows_position'] ) ) {
				$settings['carousel_arrows_position'] = 'together';
			}
		}

		$wd_nav_classes .= ' wd-style-' . $settings['tabs_style'];

		if ( 'default' === $settings['design'] ) {
			$wd_nav_classes .= ' wd-icon-pos-' . $settings['icon_alignment_design_default'];
		}

		if ( 'simple' === $settings['design'] || 'aside' === $settings['design'] || 'alt' === $settings['design'] ) {
			$wd_nav_classes .= ' wd-icon-pos-' . $settings['icon_alignment'];
		}

		// Image settings.
		$custom_image_size         = isset( $settings['image_custom_dimension']['width'] ) && $settings['image_custom_dimension']['width'] ? $settings['image_custom_dimension'] : [
			'width'  => 128,
			'height' => 128,
		];
		$render_svg_with_image_tag = apply_filters( 'woodmart_render_svg_with_image_tag', true );

		if ( isset( $settings['image']['id'] ) && $settings['image']['id'] ) {
			$image_output = '<span class="img-wrapper">' . woodmart_otf_get_image_html( $settings['image']['id'], $settings['image_size'], $settings['image_custom_dimension'] ) . '</span>';

			if ( woodmart_is_svg( $settings['image']['url'] ) ) {
				if ( $render_svg_with_image_tag ) {
					$custom_image_size = 'custom' !== $settings['image_size'] && 'full' !== $settings['image_size'] ? $settings['image_size'] : $custom_image_size;
					$image_output      = '<span class="img-wrapper">' .  woodmart_get_svg_html( $settings['image']['id'], $custom_image_size ) . '</span>';
				} else {
					$image_output = '<span class="svg-icon img-wrapper" style="width:' . esc_attr( $custom_image_size['width'] ) . 'px; height:' . esc_attr( $custom_image_size['height'] ) . 'px;">' . woodmart_get_any_svg( $settings['image']['url'], rand( 999, 9999 ) ) . '</span>';
				}
			}
		}

		$nav_tabs_wrapper_classes = '';
		if ( 'inherit' !== $settings['title_text_color_scheme'] && 'custom' !== $settings['title_text_color_scheme'] ) {
			$nav_tabs_wrapper_classes .= ' color-scheme-' . $settings['title_text_color_scheme'];
		}

		// Tabs settings.
		$first_tab_title = '';

		if ( isset( $settings['tabs_items'][0]['title'] ) ) {
			$first_tab_title = $settings['tabs_items'][0]['title'];
		}

		woodmart_enqueue_js_script( 'products-tabs' );
		woodmart_enqueue_inline_style( 'tabs' );
		woodmart_enqueue_inline_style( 'product-tabs' );

		$wrapper_classes .= woodmart_get_old_classes( ' woodmart-products-tabs' );

		?>
		<div class="wd-tabs wd-products-tabs<?php echo esc_attr( $wrapper_classes ); ?>">
			<div class="wd-tabs-header<?php echo esc_attr( $header_classes ); ?>">
				<?php if ( $settings['title'] ) : ?>
					<div class="tabs-name title">
						<?php if ( $image_output ) : ?>
							<?php echo $image_output; // phpcs:ignore ?>
						<?php endif; ?>

						<span class="tabs-text<?php echo esc_attr( $title_classes ); ?>" data-elementor-setting-key="title">
							<?php echo wp_kses( $settings['title'], woodmart_get_allowed_html() ); ?>
						</span>
					</div>
				<?php endif; ?>

				<?php if ( $settings['description'] ) : ?>
					<div class="wd-tabs-desc">
						<?php echo wp_kses( $settings['description'], woodmart_get_allowed_html() ); ?>
					</div>
				<?php endif; ?>

				<div class="wd-nav-wrapper wd-nav-tabs-wrapper tabs-navigation-wrapper<?php echo esc_attr( $nav_tabs_wrapper_classes ); ?>">

					<ul class="wd-nav wd-nav-tabs products-tabs-title<?php echo esc_attr( $wd_nav_classes ); ?>">
						<?php foreach ( $settings['tabs_items'] as $key => $item ) : ?>
							<?php
							$li_classes        = '';
							$icon_output       = '';
							$item['elementor'] = true;
							$encoded_settings  = wp_json_encode( array_intersect_key( $settings + $item, woodmart_get_elementor_products_config() ) );

							if ( 0 === $key ) {
								$li_classes .= ' wd-active';
							}

							// Icon settings.
							$custom_icon_size = isset( $item['image_custom_dimension']['width'] ) && $item['image_custom_dimension']['width'] ? $item['image_custom_dimension'] : [
								'width'  => 128,
								'height' => 128,
							];

							if ( ( ! $item['icon_type'] || 'image' === $item['icon_type'] ) && isset( $item['image']['id'] ) && $item['image']['id'] ) {
								$icon_output = woodmart_otf_get_image_html( $item['image']['id'], $item['image_size'], $item['image_custom_dimension'] );

								if ( woodmart_is_svg( $item['image']['url'] ) ) {
									$icon_output = woodmart_get_svg_html( $item['image']['id'], $custom_icon_size, array( 'class' => 'svg-icon' ) );
								}
							} elseif ( 'icon' === $item['icon_type'] && isset( $item['icon'] ) && $item['icon'] ) {
								$icon_output = woodmart_elementor_get_render_icon( $item['icon'] );
							}
							?>

							<li data-atts="<?php echo esc_attr( $encoded_settings ); ?>" class="<?php echo esc_attr( $li_classes ); ?>">
								<a href="#" class="wd-nav-link">
									<?php if ( $icon_output ) : ?>
										<span class="img-wrapper">
											<?php echo $icon_output; //phpcs:ignore ?>
										</span>
									<?php endif; ?>

									<span class="tab-label nav-link-text">
										<?php echo esc_html( $item['title'] ); ?>
									</span>
								</a>
							</li>
						<?php endforeach; ?>
					</ul>
				</div>
			</div>

			<?php if ( isset( $settings['tabs_items'][0] ) ) : ?>
				<?php echo woodmart_elementor_products_tab_template( $settings + $settings['tabs_items'][0] ); ?>
			<?php endif; ?>
		</div>
		<?php
	}
}

if ( ! function_exists( 'woodmart_elementor_products_tab_template' ) ) {
	function woodmart_elementor_products_tab_template( $settings ) {
		$is_ajax = ( defined( 'DOING_AJAX' ) && DOING_AJAX && ! woodmart_elementor_is_edit_mode() );

		$settings = wp_parse_args(
			$settings,
			array_merge(
				[
					'title' => '',
					'icon'  => '',
				],
				woodmart_get_elementor_products_config()
			)
		);

		$settings['force_not_ajax']  = 'yes';
		$settings['wrapper_classes'] = ' wd-tab-content';

		if ( ! $is_ajax ) {
			$settings['wrapper_classes'] .= ' wd-active wd-in';
		}

		if ( $is_ajax ) {
			ob_start();
		}

		unset( $settings['title'] );

		?>
		<?php if ( ! $is_ajax ) : ?>
			<div class="wd-tabs-content-wrapper<?php echo woodmart_get_old_classes( ' woodmart-tab-content' ); ?>">
			<?php woodmart_sticky_loader(); ?>
		<?php endif; ?>

		<?php echo woodmart_elementor_products_template( $settings ); ?>

		<?php if ( ! $is_ajax ) : ?>
			</div>
		<?php endif; ?>
		<?php

		if ( $is_ajax ) {
			return [
				'html' => ob_get_clean(),
			];
		}
	}
}
