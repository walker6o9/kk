<?php if (!defined('ABSPATH')) die('No direct access allowed'); ?>
<div data-css-class="woof_custom_size_search_container" class="woof_custom_size_search_container woof_container">
    <div class="woof_container_overlay_item"></div>
    <div class="woof_container_inner">
        <?php
        global $WOOF;
        $woof_custom_size = '';
        $request = $WOOF->get_request_data();

        if (isset($request['woof_custom_size']))
        {
            $woof_custom_size = $request['woof_custom_size'];
        }
        //+++
        if (!isset($placeholder))
        {
            $p = __('Search by size here ...', 'woocommerce-products-filter');
        }

        if (isset($WOOF->settings['by_custom_size']['placeholder']) AND ! isset($placeholder))
        {
            if (!empty($WOOF->settings['by_custom_size']['placeholder']))
            {
                $p = $WOOF->settings['by_custom_size']['placeholder'];
                $p = WOOF_HELPER::wpml_translate(null, $p);
                $p = __($p, 'woocommerce-products-filter');
            }


            if ($WOOF->settings['by_custom_size']['placeholder'] == 'none')
            {
                $p = '';
            }
        }
        //***
        $unique_id = uniqid('woof_custom_size_search_');
        ?>

		<<?php echo apply_filters('woof_title_tag', 'h4'); ?>><?php echo 'Size' ?></<?php echo apply_filters('woof_title_tag', 'h4'); ?>>
        <div class="woof_show_custom_size_search_container">
            <img width="36" class="woof_show_custom_size_search_loader" style="display: none;" src="<?php echo $loader_img ?>" alt="loader" />
            <a href="javascript:void(0);" data-uid="<?php echo $unique_id ?>" class="woof_custom_size_search_go <?php echo $unique_id ?>"></a>
            <input type="search" class="woof_show_custom_size_search <?php echo $unique_id ?>" id="<?php echo $unique_id ?>" data-uid="<?php echo $unique_id ?>" data-auto_res_count="<?php echo(isset($auto_res_count) ? $auto_res_count : 0) ?>" data-auto_search_by="<?php echo(isset($auto_search_by) ? $auto_search_by : "") ?>" placeholder="<?php echo(isset($placeholder) ? $placeholder : $p) ?>" name="woof_custom_size" value="<?php echo $woof_custom_size ?>" />
        </div>


    </div>
</div>