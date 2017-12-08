<?php
/**
 * Product Short Description
 *
 * Replaces the standard excerpt box.
 *
 * @author      WooThemes
 * @category    Admin
 * @package     WooCommerce/Admin/Meta Boxes
 * @version     2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

/**
 * WC_Meta_Box_Product_Size Class.
 */
class WC_Meta_Box_Product_Size {

	/**
	 * Output the metabox.
	 *
	 * @param WP_Post $post
	 */
	public static function output( $post ) {

		// Size
				woocommerce_wp_text_input( array(
					'id'          => 'coupon_amount',
					'label'       => __( 'Size', 'woocommerce' ),
					'placeholder' => wc_format_localized_price( 0 ),
					'description' => __( 'Value of the coupon.', 'woocommerce' ),
					'data_type'   => 'price',
					'desc_tip'    => true,
				) );

				/*// Checkbox
woocommerce_wp_checkbox( 
array( 
	'id'            => '_checkbox', 
	'wrapper_class' => 'show_if_simple', 
	'label'         => __('My Checkbox Field', 'woocommerce' ), 
	'description'   => __( 'Check me!', 'woocommerce' ) 
	)
); */

		/*$settings = array(
			'textarea_name' => 'excerpt',
			'quicktags'     => array( 'buttons' => 'em,strong,link' ),
			'tinymce'       => array(
				'theme_advanced_buttons1' => 'bold,italic,strikethrough,separator,bullist,numlist,separator,blockquote,separator,justifyleft,justifycenter,justifyright,separator,link,unlink,separator,undo,redo,separator',
				'theme_advanced_buttons2' => '',
			),
			'editor_css'    => '<style>#wp-excerpt-editor-container .wp-editor-area{height:175px; width:100%;}</style>',
		);

		wp_editor( htmlspecialchars_decode( $post->post_excerpt ), 'excerpt', apply_filters( 'woocommerce_product_short_description_editor_settings', $settings ) );*/
	}
}
