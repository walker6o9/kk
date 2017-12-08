<?php

namespace Allaerd\Extensions;

class WC_Product_Custom_Fields
{
    protected $fields = array ('wc_custom_breeder', 'wc_custom_sex', 'wc_custom_born_in', 'wc_custom_size', 'wc_custom_variety', 'wc_custom_estimate_time');

    public function __construct()
    {
        $this->hooks();
    }

    public function hooks()
    {
        add_filter('allaerd_importer_fields', array ($this, 'fields'));
        add_action('woocsv_product_after_body_save', array ($this, 'save'), 10, 2);
    }

    public function fields($fields)
    {
        foreach ($this->fields as $field) {
            $fields[] = $field;
        }

        return $fields;
    }

    public function save($post_id, $product)
    {
        $meta_key = 'wc_custom_breeder';
        $this->saveMetaKey($post_id, $product, $meta_key);

        $meta_key = 'wc_custom_sex';
        $this->saveMetaKey($post_id, $product, $meta_key);

		$meta_key = 'wc_custom_born_in';
        $this->saveMetaKey($post_id, $product, $meta_key);

        $meta_key = 'wc_custom_size';
        $this->saveMetaKey($post_id, $product, $meta_key);

		$meta_key = 'wc_custom_variety';
        $this->saveMetaKey($post_id, $product, $meta_key);

        $meta_key = 'wc_custom_estimate_time';
        $this->saveMetaKey($post_id, $product, $meta_key);
    }

    public function saveMetaKey($post_id, $product, $meta_key)
    {
        $key = array_search($meta_key, $product->header);
        if ($key != false) {
            $value = $product->raw_data[ $key ];
            update_post_meta($post_id, $meta_key, esc_attr( $value ));
        }
    }

}

new WC_Product_Custom_Fields();