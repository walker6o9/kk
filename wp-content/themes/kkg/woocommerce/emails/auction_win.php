<?php
/**
 * Email auction won
 *
 */

if (!defined('ABSPATH')) exit ; // Exit if accessed directly

$product_data = wc_get_product($product_id);
?>

<?php do_action('woocommerce_email_header', $email_heading); ?>
<?php if(($product_data->get_auction_type() == 'reverse' && get_option('simple_auctions_remove_pay_reverse') == 'yes')) { ?>
	<p><?php printf(__("Congratulations. You have won the auction for <a href='%s'>%s</a>. Your bid was: %s.", 'wc_simple_auctions'), get_permalink($product_id), $product_data -> get_title(), wc_price($current_bid)); ?></p>
<?} else { ?>
	<p><?php printf(__("Congratulations. You have won <a href='%s'>%s</a>. Your bid was: %s. Please click on this link to pay for your auction and contact us after payment to arrange shipping %s ", 'wc_simple_auctions'), get_permalink($product_id), $product_data -> get_title(), wc_price($current_bid), '<a href="' . esc_attr(add_query_arg("pay-auction",$product_id, $checkout_url)). '">' . __('payment', 'woocommerce') . '</a>'); ?></p>
<?php } ?>
<?php
// Show title/image 
					echo '<a href="' .get_permalink($product_id).'"><img src="' . ( $product_data->get_image_id() ? current( wp_get_attachment_image_src( $product_data->get_image_id(), 'full' ) ) : wc_placeholder_img_src() ) . '" alt="' . esc_attr__( 'Product image', 'woocommerce' ) . '" height="325px" width="200px" style="vertical-align:middle; text-align:center;margin-left: 10px;" /><br>';
				
				// Product name
				echo apply_filters( 'woocommerce_order_item_name', $product_data->get_name(), $product_data, false );
				echo '</a>';
			?>

<?php do_action('woocommerce_email_footer'); ?>