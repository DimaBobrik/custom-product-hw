<?php
// Disable Gutenberg Completely.
if ( version_compare( $GLOBALS['wp_version'], '5.0-beta', '>' ) ) {
	// WP > 5 beta
	add_filter( 'use_block_editor_for_post_type', '__return_false', 100 );
} else {
	// WP < 5 beta
	add_filter( 'gutenberg_can_edit_post_type', '__return_false' );
}

// Register Style and Scripts.
function register_styles(): void {
	$theme_version = wp_get_theme()->get( 'Version' );
	wp_enqueue_style( 'main-style', get_stylesheet_uri(), array(), $theme_version );
	wp_deregister_script( 'wp-embed' );
	wp_deregister_script( 'jquery' );
	wp_deregister_script( 'jquery-migrate' );
	wp_enqueue_script( 'jquery', 'https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js', [], '3.4.1', false );
	wp_enqueue_script( 'product', get_template_directory_uri() . '/js/product.js', [], '3.4.1', false );

}

add_action( 'wp_enqueue_scripts', 'register_styles' );

// Add Post Thumbnails Support for Custom Post Type Product.
add_theme_support( 'post-thumbnails', array( 'product' ) );

// Register Custom Post Type and Taxonomy for Product.
if ( ! function_exists( 'custom_post_type' ) ) {

// Register Custom Post Type.
	function custom_post_type() {

		$labels = array(
			'name'                  => _x( 'Product', 'Post Type General Name', 'custom-product' ),
			'singular_name'         => _x( 'Product', 'Post Type Singular Name', 'custom-product' ),
			'menu_name'             => __( 'Products', 'custom-product' ),
			'name_admin_bar'        => __( 'Product', 'custom-product' ),
			'archives'              => __( 'Item Archives', 'custom-product' ),
			'attributes'            => __( 'Item Attributes', 'custom-product' ),
			'parent_item_colon'     => __( 'Parent Item:', 'custom-product' ),
			'all_items'             => __( 'All Items', 'custom-product' ),
			'add_new_item'          => __( 'Add New Item', 'custom-product' ),
			'add_new'               => __( 'Add New', 'custom-product' ),
			'new_item'              => __( 'New Item', 'custom-product' ),
			'edit_item'             => __( 'Edit Item', 'custom-product' ),
			'update_item'           => __( 'Update Item', 'custom-product' ),
			'view_item'             => __( 'View Item', 'custom-product' ),
			'view_items'            => __( 'View Items', 'custom-product' ),
			'search_items'          => __( 'Search Item', 'custom-product' ),
			'not_found'             => __( 'Not found', 'custom-product' ),
			'not_found_in_trash'    => __( 'Not found in Trash', 'custom-product' ),
			'featured_image'        => __( 'Featured Image', 'custom-product' ),
			'set_featured_image'    => __( 'Set featured image', 'custom-product' ),
			'remove_featured_image' => __( 'Remove featured image', 'custom-product' ),
			'use_featured_image'    => __( 'Use as featured image', 'custom-product' ),
			'insert_into_item'      => __( 'Insert into item', 'custom-product' ),
			'uploaded_to_this_item' => __( 'Uploaded to this item', 'custom-product' ),
			'items_list'            => __( 'Items list', 'custom-product' ),
			'items_list_navigation' => __( 'Items list navigation', 'custom-product' ),
			'filter_items_list'     => __( 'Filter items list', 'custom-product' ),
		);
		$args   = array(
			'label'               => __( 'Product', 'custom-product' ),
			'description'         => __( 'Product Description', 'custom-product' ),
			'labels'              => $labels,
			'supports'            => array( 'title', 'thumbnail' ),
			'taxonomies'          => array(),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'menu_position'       => 5,
			'show_in_admin_bar'   => true,
			'show_in_nav_menus'   => true,
			'can_export'          => true,
			'has_archive'         => false,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'page',
			'show_in_rest'        => true,
		);
		register_post_type( 'product', $args );

	}

	add_action( 'init', 'custom_post_type', 0 );

// Register Custom Taxonomy.
	function custom_taxonomy() {

		$labels = array(
			'name'                       => _x( 'Product Taxonomies', 'Taxonomy General Name', 'custom-product' ),
			'singular_name'              => _x( 'Product Taxonomy', 'Taxonomy Singular Name', 'custom-product' ),
			'menu_name'                  => __( 'Product Taxonomy', 'custom-product' ),
			'all_items'                  => __( 'All Items', 'custom-product' ),
			'parent_item'                => __( 'Parent Item', 'custom-product' ),
			'parent_item_colon'          => __( 'Parent Item:', 'custom-product' ),
			'new_item_name'              => __( 'New Item Name', 'custom-product' ),
			'add_new_item'               => __( 'Add New Item', 'custom-product' ),
			'edit_item'                  => __( 'Edit Item', 'custom-product' ),
			'update_item'                => __( 'Update Item', 'custom-product' ),
			'view_item'                  => __( 'View Item', 'custom-product' ),
			'separate_items_with_commas' => __( 'Separate items with commas', 'custom-product' ),
			'add_or_remove_items'        => __( 'Add or remove items', 'custom-product' ),
			'choose_from_most_used'      => __( 'Choose from the most used', 'custom-product' ),
			'popular_items'              => __( 'Popular Items', 'custom-product' ),
			'search_items'               => __( 'Search Items', 'custom-product' ),
			'not_found'                  => __( 'Not Found', 'custom-product' ),
			'no_terms'                   => __( 'No items', 'custom-product' ),
			'items_list'                 => __( 'Items list', 'custom-product' ),
			'items_list_navigation'      => __( 'Items list navigation', 'custom-product' ),
		);
		$args   = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => true,
			'show_tagcloud'     => true,
			'show_in_rest'      => true,
		);
		register_taxonomy( 'product_taxonomy', array( 'product' ), $args );

	}

	add_action( 'init', 'custom_taxonomy', 0 );
}

// Register Meta Boxes for Product.

add_filter( 'rwmb_meta_boxes', 'product_register_meta_boxes' );

function product_register_meta_boxes( $meta_boxes ) : array {
	$meta_boxes[] = array(
		'title'      => esc_html__( 'Product Settings', 'custom-product' ),
		'id'         => 'product_fields',
		'post_types' => array( 'product' ),
		'fields'     => array(
			array(
				'type' => 'text',
				'name' => esc_html__( 'Product Title', 'custom-product' ),
				'id'   => 'text_product_title',
			),
			array(
				'type' => 'wysiwyg',
				'name' => esc_html__( 'Product Description', 'online-generator' ),
				'id'   => 'product_description',
			),
			array(
				'type' => 'divider',
			),
			array(
				'type' => 'number',
				'name' => esc_html__( 'Price', 'custom-product' ),
				'id'   => 'product_price',
			),
			array(
				'type' => 'number',
				'name' => esc_html__( 'Sale Price', 'custom-product' ),
				'id'   => 'sale_price',
			),
			array(
				'type' => 'checkbox',
				'name' => esc_html__( 'Is on Sale ?', 'custom-product' ),
				'id'   => 'is_on_sale',
				'std'  => true,
			),
			array(
				'type' => 'divider',
			),
			array(
				'type' => 'oembed',
				'name' => esc_html__( 'Product Youtube Video', 'custom-product' ),
				'id'   => 'oembed_product_video',
			),
			array(
				'id'               => 'product_image',
				'name'             => 'Gallery Images',
				'type'             => 'image_advanced',
				'force_delete'     => false,
				'max_file_uploads' => 6,
				'max_status'       => false,
				'image_size'       => 'thumbnail',
			),
		),
	);

	return $meta_boxes;
}

// Register Shortcode Product
// @param integer:product_id id of product
// @param color:product_box_bg background of product box

function short_product_box( $atts = array() ): mixed {
	if ( ! empty( $atts['product_id'] ) ) {
		$product_box = product_box( $atts );
		return $product_box;
	}
	return false;
}

function product_box( $product_box_options = false ) {
	$product_title     = rwmb_get_value( 'text_product_title', array(), $product_box_options['product_id'] );
	$product_image_url = get_the_post_thumbnail_url( $product_box_options['product_id'] );
	$price             = '1' === rwmb_get_value( 'is_on_sale', array(), $product_box_options['product_id'] )
		? rwmb_get_value( 'sale_price', array(), $product_box_options['product_id'] )
		: rwmb_get_value( 'product_price', array(), $product_box_options['product_id'] );
	$product_box_bg    = isset( $product_box_options['product_box_bg'] ) && ! empty( $product_box_options['product_box_bg'] )
		? $product_box_options['product_box_bg']
		: '#ffffff';
	?>
	<div class="product-box" style="background-color: <?php echo $product_box_bg; ?>">
		<a href="<?php echo get_permalink( $product_box_options['product_id'] ) ?>"
		   title="<?php echo esc_html( $product_title ); ?>">
			<div class="image-holder">
				<img src="<?php echo esc_url( $product_image_url ); ?>"
				     class="product-image"
				     alt="<?php echo $product_title; ?>">
			</div>
			<div class="product-title"><?php echo esc_html( $product_title ); ?></div>
			<?php if ( ! empty( $price ) ) { ?>
				<div class="price">
					<h4 class="price-title">Product Price</h4>
					<?php echo esc_html( $price ); ?>
				</div>
			<?php } ?>
		</a>
	</div>
	<?php
}

add_shortcode( 'product_box', 'short_product_box' );

// Change Color of Address Bar Mobile

function address_mobile_address_bar() {
	$color = "#008509";
	echo '<meta name="theme-color" content="' . $color . '">';
	echo '<meta name="msapplication-navbutton-color" content="' . $color . '">';
	echo '<meta name="apple-mobile-web-app-capable" content="yes">';
	echo '<meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">';
}

add_action( 'wp_head', 'address_mobile_address_bar' );

// Register Rest API Product
// example url: /wp-json/my-route/v1/my-another-products/3
// taxonomy slug must be string: my-another-products
// taxonomy id must be integer: 3

add_action( 'rest_api_init', function () {
	register_rest_route( 'my-route/v1', '(?P<stringvar>.+)/(?P<id>\d+)', array(
		'methods'  => 'GET',
		'callback' => 'get_product_posts',
		'args'     => array(
			'id'        => array(
				'validate_callback' => function ( $param, $request, $key ) : bool {
					if ( is_numeric( $param ) ) {
						$taxonomy = get_term( $param );

						return ! empty( $taxonomy );
					}
				},
			),
			'stringvar' => array(
				'validate_callback' => function ( $param, $request, $key ) : bool {
					if ( is_string( $param ) ) {
						$taxonomy = get_term_by( 'slug', $param, 'product_taxonomy' );

						return ! empty( $taxonomy );
					}
				},
			),
		),
	) );
} );

function get_product_posts( array $taxonomy_info ) : object {
	$args       = array(
		'posts_per_page'   => - 1,
		'offset'           => 0,
		'order'            => 'rand',
		'post_type'        => 'product',
		'post_status'      => 'publish',
		'suppress_filters' => true,
		'tax_query'        => array(
			array(
				'taxonomy' => 'product_taxonomy',
				'field'    => 'term_id',
				'terms'    => $taxonomy_info['id'],
			),
		),
	);
	$posts_list = get_posts( $args );
	$post_data  = array();
	foreach ( $posts_list as $posts ) {
		$post_id             = $posts->ID;
		$post_author         = $posts->post_author;
		$post_title          = $posts->post_title;
        $product_title       = ! empty( rwmb_get_value( 'text_product_title', array(), $post_id ) )
            ? rwmb_get_value( 'text_product_title', array(), $post_id ) : null;
        $product_description = ! empty( rwmb_get_value( 'product_description', array(), $post_id ) )
            ? rwmb_get_value( 'product_description', array(), $post_id ) : null;
        $product_price       = ! empty( rwmb_get_value( 'product_price', array(), $post_id ) )
            ? rwmb_get_value( 'product_price', array(), $post_id ) : null;
        $sale_price          = ! empty( rwmb_get_value( 'sale_price', array(), $post_id ) )
            ? rwmb_get_value( 'sale_price', array(), $post_id ) : null;
        $is_on_sale          = '1' === rwmb_get_value( 'is_on_sale', array(), $post_id );
        $product_image       = ! empty( get_the_post_thumbnail_url( $post_id ) )
            ? get_the_post_thumbnail_url( $post_id ) : null;

		$post_data[ $post_id ]['author']              = $post_author;
		$post_data[ $post_id ]['title']               = $post_title;
		$post_data[ $post_id ]['product_title']       = $product_title;
		$post_data[ $post_id ]['product_description'] = $product_description;
		$post_data[ $post_id ]['product_price']       = $product_price;
		$post_data[ $post_id ]['sale_price']          = $sale_price;
		$post_data[ $post_id ]['is_on_sale']          = $is_on_sale;
		$post_data[ $post_id ]['product_image']       = $product_image;
	}

	wp_reset_postdata();

	return rest_ensure_response( $post_data );
}

// Disable Admin Bar for editor with name 'wp-test'

if ( is_user_logged_in() && current_user_can( 'editor' ) ) {
	$current_user = wp_get_current_user();
	if ( 'wp-test' === $current_user->data->user_nicename ) {
		add_filter( 'show_admin_bar', '__return_false' );
	}
}