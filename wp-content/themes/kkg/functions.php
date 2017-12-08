<?php
//Create a Child Theme and Enque Styles and Scripts from Parent

add_action( 'wp_enqueue_scripts', 'enqueue_parent_styles' );

function enqueue_parent_styles() {
   wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
}

//remove lightbox
add_action( 'after_setup_theme', 'kkf_setup' ,12);
function kkf_setup() {
	remove_theme_support( 'wc-product-gallery-lightbox' );
	remove_theme_support( 'wc-product-gallery-zoom' );//remove this line to bring the zoom back

}
function load_hotjar() {

if ( is_page( 'wholesale' ) || '27382' == $post->post_parent || is_woocommerce() ) {    
// the page is "Wholesale", or the parent of the page is "Wholesale"
echo '<!-- Removed Hotjar Tracking Code for https://kodamakoifarm.com -->';
} else {?>
<!-- Added Hotjar Tracking Code for https://kodamakoifarm.com -->
<script>
    (function(h,o,t,j,a,r){
        h.hj=h.hj||function(){(h.hj.q=h.hj.q||[]).push(arguments)};
        h._hjSettings={hjid:551324,hjsv:5};
        a=o.getElementsByTagName('head')[0];
        r=o.createElement('script');r.async=1;
        r.src=t+h._hjSettings.hjid+j+h._hjSettings.hjsv;
        a.appendChild(r);
    })(window,document,'//static.hotjar.com/c/hotjar-','.js?sv=');
</script>
<?php };
};

add_action('wp_head', 'load_hotjar');

/**
 * WooCommerce REPLACEMENT Function
 * see https://docs.woocommerce.com/wc-apidocs/function-woocommerce_related_products.html
 * --------------------------
 *
 * Change number of related products on product page
 * Set your own value for 'posts_per_page'
 *
 */ 


 function woocommerce_related_products( $args = array() ) {
        global $product, $woocommerce_loop;
        //Remove completed auctions from related products section

 	$now = current_time( 'mysql' ) ;
 	$tempargs = array( 
	       'post_type' => 'product',
	       'posts_per_page' => -1,  
		'columns' => 4,  
	       	'meta_key'     => '_auction_dates_to',
	       	'meta_value'   => $now,
		'meta_compare' => '<'
	       	);
	      
 	 $query = new WP_Query( $tempargs );
		while ( $query ->have_posts() ) : $query->the_post();
   			 $temp[] = get_the_ID() ;
    		endwhile;
    		
	//$exclude_ids =  array_merge($temp,$product->get_upsell_ids()) ;
 		$exclude_ids =  array_merge($temp,$product->get_upsell_ids()) ;

        $defaults = array(
            'posts_per_page' => 2,
            'columns'        => 2,
            'orderby'        => 'rand',
            'order'          => 'desc',
            'post__not_in'          => array(),

        );

        $args = wp_parse_args( $args, $defaults );
 	//$args['post__not_in'] =   $exclude_ids;
 	$args['posts_per_page'] =   '12';

        if ( ! $product ) {
            return;
        }
        //NEED TO MAKE THIS CONDITIONAL SO THAT IT ONLY AFFECTS AUCTION PRODUCTS. 
	 $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'],$exclude_ids ) ), 'wc_products_array_filter_visible' );
	/**Should be something like this
	if (in_array('555',$product->get_category_ids())){
      	  // Get visble related products exlcuding all of the completed auctions then sort them at random.
     	  $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'],$exclude_ids ) ), 'wc_products_array_filter_visible' );
	}else //if not an auction product
       	 // Get visble related products then sort them at random.
      	  $args['related_products'] = array_filter( array_map( 'wc_get_product', wc_get_related_products( $product->get_id(), $args['posts_per_page'], $product->get_upsell_ids() ) ), 'wc_products_array_filter_visible' );
	*/

        
        // Handle orderby.
        $args['related_products'] = wc_products_array_orderby( $args['related_products'], $args['orderby'], $args['order'] );

        // Set global loop values.
        $woocommerce_loop['name']    = 'related';
        $woocommerce_loop['columns'] = apply_filters( 'woocommerce_related_products_columns', $args['columns'] );

        wc_get_template( 'single-product/related.php', $args );
    }
/**
*END OF WooCommerce REPLACEMENT Function
**/
    

//Show Auction Timer "Everywhere" (from FAQ #11 on Simple AUction Docs)
add_action( 'woocommerce_after_shop_loop_item_title','wpgenie_show_counter_in_loop',50 );

		function wpgenie_show_counter_in_loop(){

			global $product;

			$time = '';

			if(!isset ($product))
				return;
			if('auction' != $product->product_type)
				return;

			$timetext = __('Time left', 'wc_simple_auctions');

			if(!$product->is_started()){
				$timetext = __('Starting in', 'wc_simple_auctions');
				$counter_time = $product->get_seconds_to_auction();
			} else{
				$counter_time = $product->get_seconds_remaining();
			}

			$time = '<span class="time-left">'.$timetext.'</span>
			<div class="auction-time-countdown"
			data-time="'.$counter_time.'"
			data-auctionid="'.$product->id.'" data-format="'.get_option(
			'simple_auctions_countdown_format' ).'"></div>';

			if($product->is_closed()){
				$time = '<span class="has-finished">'.__('Auction finished','wc_simple_auctions').'</span>';
			}
			echo $time;
		}
		

//remove "downloads" from My Account page
function custom_my_account_menu_items( $items ) {
    unset($items['downloads']);
    return $items;
}
add_filter( 'woocommerce_account_menu_items', 'custom_my_account_menu_items' );


//Redirect product pages to the login/register page if not logged in
add_action( 'template_redirect', 'redirect_non_logged_users_to_specific_page' );

function redirect_non_logged_users_to_specific_page() {
if( !is_user_logged_in() && is_product())  {
$redirect = get_permalink();
    wp_redirect('/shop/my-account/?redirect_to='.$redirect);
    exit;
}

}
//Show different text for when Auction and Wholesale product prices are hidden
add_filter('catalog_visibility_alternate_price_html', 'my_alternate_price_text', 10, 1);

function my_alternate_price_text($content) {
	global $product;

 if('auction' == $product->product_type) {
 return 'Login to View Price & Bid';
 } else 
 //Show something different if not auction (THIS CURRENTLY NEVER SHOWS because of visibility plugin not allowing people to see these unless they have Wholesale user)
  return 'Register for Wholesale Prices';

}


//Force Auction Activity Tab to Tab Manager

add_filter('woocommerce_tab_manager_integration_tab_allowed', 'auction_activity_tab');
function auction_activity_tab($allowed, $tab = null) {
	if($tab == 'simle_auction_history') {
		$allowed = true;
		return false;
	}
}
//Redirect users back to the product page they wanted to view after login or registration

function custom_registration_redirect() {
// check for a referer

	$referer = $_GET['redirect_to'];
	// if there was a referer
	if( $referer ) {
		$post_id = url_to_postid( $referer );
		$post_data = get_post( $post_id );
		if( $post_data ) {
			// if the refering page was a single product, let's append a hidden field to redirect the user to
			if( isset( $post_data->post_type ) && $post_data->post_type == 'product' ) {
					return $referer ;

			}
		}
	}else $referer = get_permalink( wc_get_page_id('auction') );
	return $referer ;
}

add_filter( 'registration_redirect', 'custom_registration_redirect',2 );
add_filter( 'woocommerce_registration_redirect', 'custom_registration_redirect',2 );

//Allow people to have more than one auction product in their cart
add_filter('woocommerce_simple_auction_empty_cart', 'mutiple_auction_products' );
function mutiple_auction_products( $array){
	return false;
}

//change projects to Koi Champions
function et_pb_register_posttypes() {
$labels = array(
'name' => esc_html__( 'Koi Champions', 'et_builder' ),
'singular_name' => esc_html__( 'Koi Champion', 'et_builder' ),
'add_new' => esc_html__( 'Add New', 'et_builder' ),
'add_new_item' => esc_html__( 'Add New Koi Champion', 'et_builder' ),
'edit_item' => esc_html__( 'Edit Koi Champion', 'et_builder' ),
'new_item' => esc_html__( 'New Koi Champion', 'et_builder' ),
'all_items' => esc_html__( 'All Koi Champions', 'et_builder' ),
'view_item' => esc_html__( 'View Koi Champion', 'et_builder' ),
'search_items' => esc_html__( 'Search Koi Champions', 'et_builder' ),
'not_found' => esc_html__( 'Nothing found', 'et_builder' ),
'not_found_in_trash' => esc_html__( 'Nothing found in Trash', 'et_builder' ),
'parent_item_colon' => '',
);

$args = array(
'labels' => $labels,
'public' => true,
'publicly_queryable' => true,
'show_ui' => true,
'can_export' => true,
'show_in_nav_menus' => true,
'query_var' => true,
'has_archive' => true,
'rewrite' => apply_filters( 'et_project_posttype_rewrite_args', array(
'feeds' => true,
'slug' => 'champion-koi',
'with_front' => false,
) ),
'capability_type' => 'post',
'hierarchical' => false,
'menu_position' => null,
'supports' => array( 'title', 'author', 'editor', 'thumbnail', 'excerpt', 'comments', 'revisions', 'custom-fields' ),
);

register_post_type( 'project', apply_filters( 'et_project_posttype_args', $args ) );

$labels = array(
'name' => esc_html__( 'Koi Types', 'et_builder' ),
'singular_name' => esc_html__( 'Koi Type', 'et_builder' ),
'search_items' => esc_html__( 'Search Koi Types', 'et_builder' ),
'all_items' => esc_html__( 'All Koi Types', 'et_builder' ),
'parent_item' => esc_html__( 'Parent Koi Type', 'et_builder' ),
'parent_item_colon' => esc_html__( 'Parent Koi Type:', 'et_builder' ),
'edit_item' => esc_html__( 'Edit Koi Type', 'et_builder' ),
'update_item' => esc_html__( 'Update Koi Type', 'et_builder' ),
'add_new_item' => esc_html__( 'Add New Koi Type', 'et_builder' ),
'new_item_name' => esc_html__( 'New Koi Type Name', 'et_builder' ),
'menu_name' => esc_html__( 'Koi Types', 'et_builder' ),
);

register_taxonomy( 'project_category', array( 'project' ), array(
'hierarchical' => true,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'koi-type'),
) );

$labels = array(
'name' => esc_html__( 'Koi Champion Tags', 'et_builder' ),
'singular_name' => esc_html__( 'Koi Champion Tag', 'et_builder' ),
'search_items' => esc_html__( 'Search Koi Tags', 'et_builder' ),
'all_items' => esc_html__( 'All Koi Tags', 'et_builder' ),
'parent_item' => esc_html__( 'Parent Koi Tag', 'et_builder' ),
'parent_item_colon' => esc_html__( 'Parent Koi Tag:', 'et_builder' ),
'edit_item' => esc_html__( 'Edit Koi Tag', 'et_builder' ),
'update_item' => esc_html__( 'Update Koi Tag', 'et_builder' ),
'add_new_item' => esc_html__( 'Add New Koi Tag', 'et_builder' ),
'new_item_name' => esc_html__( 'New Koi Tag Name', 'et_builder' ),
'menu_name' => esc_html__( 'Koi Tags', 'et_builder' ),
);

register_taxonomy( 'project_tag', array( 'project' ), array(
'hierarchical' => false,
'labels' => $labels,
'show_ui' => true,
'show_admin_column' => true,
'query_var' => true,
'rewrite' => array( 'slug' => 'koi-tag'),

) );
}

//override project meta box from core functions file

function et_pb_portfolio_meta_box() { ?>
	<div class="et_project_meta">
		<strong class="et_project_meta_title"><?php echo esc_html__( 'Search Our Koi Champions by Tag', 'Divi' ); ?></strong>
		<p><?php echo get_the_term_list( get_the_ID(), 'project_tag', '', ', ' ); ?></p>

		<strong class="et_project_meta_title"><?php echo esc_html__( 'Posted on', 'Divi' ); ?></strong>
		<p><?php echo get_the_date(); ?></p>
	</div>
<?php }

