<?php
/*
Template Name: Home Page
Template Post Type: page
*/
get_header();
$args          = array(
	'post_type'      => 'product',
	'posts_per_page' => - 1,
	'post_status'    => 'publish',
);
$product_pages = get_posts( $args );

?>
<div id="ThePage">
	<div class="entry">
		<div class="product-grid">
			<?php
			if ( ! empty( $product_pages ) ) {
				foreach ( $product_pages as $product_page ) {
					$product_page_id = $product_page->ID;
					$product_title   = rwmb_get_value( 'text_product_title', array(), $product_page_id );
					?>
					<a href="<?php echo esc_url( get_permalink( $product_page_id ) ); ?>" class="product"
					   title="<?php echo esc_attr( $product_title ); ?>">
						<?php if ( '1' === rwmb_get_value( 'is_on_sale', array(), $product_page_id ) ) { ?>
							<div class="on-sale">
								on-sale
							</div>
						<?php } ?>
						<div class="product-image-holder">
							<img src="<?php echo get_the_post_thumbnail_url( $product_page_id ); ?>"
							     class="product-image"
							     alt="<?php echo esc_attr( $product_title ); ?>">
						</div>
						<div class="product-title"><?php echo esc_html( $product_title ); ?></div>
					</a>
					<?php
				}
			} else {
				?>
				<p class="no-content">No content for this page.</p>
				<?php
			}
			?>
		</div>
	</div>
	<?php echo do_shortcode( '[product_box product_id=65 product_box_bg=green]' ); ?>
</div>
<?php get_footer(); ?>
