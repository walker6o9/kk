<?php
/**
 * Customer outbid email
 *
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly 


$product_data = wc_get_product(  $product_id );

?>

<?php do_action('woocommerce_email_header', $email_heading); ?>
<p><?php printf( __( "Hi there. You have placed a bid on <a href='%s'>%s</a>", 'wc_simple_auctions' ),get_permalink($product_id), $product_data->get_title(), wc_price($product_data->get_curent_bid())); ?></p>
<?php
				// Show title/image 
					echo '<a href="' .get_permalink($product_id).'"><img src="' . ( $product_data->get_image_id() ? current( wp_get_attachment_image_src( $product_data->get_image_id(), 'full' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woocommerce' ) . '" height="325px" width="200px" style="vertical-align:middle; text-align:center;margin-left: 10px;" /><br>';
				
				// Product name
				echo apply_filters( 'woocommerce_order_item_name', $product_data->get_name(), $product_data, false );
				echo '</a>';
			?>
	
<?php do_action('woocommerce_email_footer'); ?>