<?php
/**
 * The template for displaying 404 pages (Not Found)
 */

get_header(); ?>

<div class="wd-content-area site-content">

	<header class="page-header">
		<h3 class="title"><?php esc_html_e( 'Not Found', 'woodmart' ); ?></h3>
	</header>

	<div class="page-content">
		<h1><?php esc_html_e( 'This is somewhat embarrassing, isn&rsquo;t it?', 'woodmart' ); ?></h1>
		<p><?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'woodmart' ); ?></p>

		<?php
		woodmart_search_form(
			array(
				'post_type' => apply_filters( 'woodmart_404_search_post_type', 'post' ),
			)
		);
		?>
	</div>

</div>

<?php get_footer(); ?>