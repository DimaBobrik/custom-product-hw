<?php get_header();
$product_title = ! empty( rwmb_get_value( 'text_product_title' ) ) ? rwmb_get_value( 'text_product_title' ) : get_the_title();
?>
	<div id="ThePage">
		<div class="entry">
			<div class="product">
				<h1 class="product-title"><?php echo esc_html( $product_title ); ?></h1>
				<div class="row">
					<div class="product-media">
						<div class="product-gallery">
							<div class="image-holder">
								<img src="<?php echo esc_url( get_the_post_thumbnail_url() ); ?>" class="product-image"
								     alt="<?php echo esc_html( $product_title ); ?>">
							</div>
							<div class="gallery-images">
								<?php
								$images = rwmb_meta( 'product_image' );
								if ( ! empty( $images ) ) {
									foreach ( $images as $image ) {
										?>
										<img class="gallery-image" src="<?php echo esc_url( $image['url'] ); ?>"
										     alt="<?php echo esc_html( $image['alt'] ); ?>">
										<?php
									}
								}
								?>
							</div>
						</div>
					</div>
					<div class="product-info">
						<?php $price = '1' === rwmb_get_value( 'is_on_sale' ) ? rwmb_get_value( 'sale_price' ) : rwmb_get_value( 'product_price' ); ?>
						<?php if ( ! empty( $price ) ) { ?>
							<div class="price">
								<h4 class="price-title">Product Price</h4>
								<?php echo esc_html( $price ); ?>
							</div>
						<?php } ?>
						<div class="description">
							<h4 class="description-title">Product Description</h4>
							<?php
							echo rwmb_meta( 'product_description' );
							$video_src  = rwmb_get_value( 'oembed_product_video' );
							$parsed_src = explode( '/', $video_src );
							$youTubeID  = array_pop( $parsed_src );
							if ( ! empty( $youTubeID ) ) {
								?>
								<div class="product-video">
									<h4 class="video-title">Product Video</h4>
									<iframe src="https://www.youtube.com/embed/<?php echo $youTubeID; ?>"
									        title="<?php echo esc_html( $product_title ); ?>" frameborder="0"
									        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
									        allowfullscreen></iframe>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
			<?php
			$resent_post_ids = wp_get_post_terms( $post->ID, 'product_taxonomy', array( 'fields' => 'ids' ) );
			if ( ! empty( $resent_post_ids ) ) {
				$args          = array(
					'posts_per_page'   => - 1,
					'offset'           => 0,
					'order'            => 'rand',
					'exclude'          => $post->ID,
					'post_type'        => 'product',
					'post_status'      => 'publish',
					'suppress_filters' => true,
					'tax_query'        => array(
						array(
							'taxonomy' => 'product_taxonomy',
							'field'    => 'term_id',
							'terms'    => $resent_post_ids[0],
						),
					),
				);
				$related_posts = get_posts( $args );
			}
			if ( ! empty( $related_posts ) ) {
				?>
				<div class="related-products">
					<h3 class="related-products-title">Related Products</h3>
					<div class="related-products-holder">
						<?php
						foreach ( $related_posts as $related_post ) {
							$related_product_title = rwmb_meta( 'text_product_title', array(), $related_post->ID );;
							?>
							<a href="<?php echo esc_url( get_permalink( $related_post->ID ) ); ?>"
							   class="related-product-link"
							   title="<?php echo $related_product_title; ?>">
								<img src="<?php echo esc_url( get_the_post_thumbnail_url( $related_post->ID ) ); ?>"
								     class="related-product-image"
								     alt="<?php echo $related_product_title; ?>">
								<div class="related-product-title">
									<?php echo $related_product_title; ?>
								</div>
							</a>
						<?php } ?>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
<?php
get_footer(); ?>