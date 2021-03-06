<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');
?>
 
<li data-key="<?php echo $key ?>" class="woof_options_li">

    <?php
    $show = 0;
    if (isset($woof_settings[$key]['show']))
    {
        $show = $woof_settings[$key]['show'];
    }
    ?>
	 
    <a href="#" class="help_tip woof_drag_and_drope" data-tip="<?php _e("drag and drope", 'woocommerce-products-filter'); ?>"><img src="<?php echo WOOF_LINK ?>img/move.png" alt="<?php _e("move", 'woocommerce-products-filter'); ?>" /></a>

    <strong style="display: inline-block; width: 176px;"><?php _e("Search by variety", 'woocommerce-products-filter'); ?>:</strong>

    <img class="help_tip" data-tip="<?php _e('Show textinput for searching by products title', 'woocommerce-products-filter') ?>" src="<?php echo WP_PLUGIN_URL ?>/woocommerce/assets/images/help.png" height="16" width="16" />

    <div class="select-wrap">
        <select name="woof_settings[<?php echo $key ?>][show]" class="woof_setting_select">
            <option value="0" <?php echo selected($show, 0) ?>><?php _e('No', 'woocommerce-products-filter') ?></option>
            <option value="1" <?php echo selected($show, 1) ?>><?php _e('Yes', 'woocommerce-products-filter') ?></option>
        </select>
    </div>

    <input type="button" value="<?php _e('additional options', 'woocommerce-products-filter') ?>" data-key="<?php echo $key ?>" data-name="<?php _e("Search by Born In", 'woocommerce-products-filter'); ?>" class="woof-button js_woof_options js_woof_options_<?php echo $key ?>" />

    <?php
    if (!isset($woof_settings[$key]['title']))
    {
        $woof_settings[$key]['title'] = '';
    }

    if (!isset($woof_settings[$key]['placeholder']))
    {
        $woof_settings[$key]['placeholder'] = '';
    }

     if (!isset($woof_settings[$key]['search_by_full_word']))
    {
        $woof_settings[$key]['search_by_full_word'] = 0;
    }
         
    if (!isset($woof_settings[$key]['autocomplete']))
    {
        $woof_settings[$key]['autocomplete'] = 0;
    }

    if (!isset($woof_settings[$key]['post_links_in_autocomplete']))
    {
        $woof_settings[$key]['post_links_in_autocomplete'] = 0;
    }
    
    if (!isset($woof_settings[$key]['how_to_open_links']))
    {
        $woof_settings[$key]['how_to_open_links'] = 0;
    }

    ?>

    <input type="hidden" name="woof_settings[<?php echo $key ?>][title]" value="<?php echo $woof_settings[$key]['title'] ?>" />
    <input type="hidden" name="woof_settings[<?php echo $key ?>][placeholder]" value="<?php echo $woof_settings[$key]['placeholder'] ?>" />
    <input type="hidden" name="woof_settings[<?php echo $key ?>][search_by_full_word]" value="<?php echo $woof_settings[$key]['search_by_full_word'] ?>" />
    <input type="hidden" name="woof_settings[<?php echo $key ?>][autocomplete]" value="<?php echo $woof_settings[$key]['autocomplete'] ?>" />
    <input type="hidden" name="woof_settings[<?php echo $key ?>][post_links_in_autocomplete]" value="<?php echo $woof_settings[$key]['post_links_in_autocomplete'] ?>" />
    <input type="hidden" name="woof_settings[<?php echo $key ?>][how_to_open_links]" value="<?php echo $woof_settings[$key]['how_to_open_links'] ?>" />
      
    <div id="woof-modal-content-<?php echo $key ?>" style="display: none;">
        <div class="woof-form-element-container">

                <div class="woof-name-description">
                    <strong><?php _e('Title text', 'woocommerce-products-filter') ?></strong>
                    <span><?php _e('Leave it empty if you not need this', 'woocommerce-products-filter') ?></span>
                </div>

                <div class="woof-form-element">
                    <input type="text" class="woof_popup_option" data-option="title" placeholder="" value="" />
                </div>
        </div>

        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php _e('Placeholder text', 'woocommerce-products-filter') ?></strong>
                <span><?php _e('Leave it empty if you not need this', 'woocommerce-products-filter') ?></span>
                <span><?php _e('Set "none" to disable placeholder for this textinput', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <input type="text" class="woof_popup_option" data-option="placeholder" placeholder="" value="" />
            </div>

        </div>

 <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php _e('Search by full word only', 'woocommerce-products-filter') ?></strong>
                <span><?php _e('The result is only with the full coincidence of words', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <?php
                $autocomplete = array(
                    0 => __('No', 'woocommerce-products-filter'),
                    1 => __('Yes', 'woocommerce-products-filter')
                );
                ?>

                <div class="select-wrap">
                    <select class="woof_popup_option" data-option="search_by_full_word">
                        <?php foreach ($autocomplete as $key => $value) : ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

        </div>
         

        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php _e('Autocomplete', 'woocommerce-products-filter') ?></strong>
                <span><?php _e('Autocomplete relevant variants in by_text textinput', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <?php
                $autocomplete = array(
                    0 => __('No', 'woocommerce-products-filter'),
                    1 => __('Yes', 'woocommerce-products-filter')
                );
                ?>

                <div class="select-wrap">
                    <select class="woof_popup_option" data-option="autocomplete">
                        <?php foreach ($autocomplete as $key => $value) : ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

        </div>


        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php _e('Links to posts in suggestion', 'woocommerce-products-filter') ?></strong>
                <span><?php _e('Direct links to posts in autocomplete suggestion', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <?php
                $post_links_in_autocomplete = array(
                    0 => __('No', 'woocommerce-products-filter'),
                    1 => __('Yes', 'woocommerce-products-filter')
                );
                ?>

                <div class="select-wrap">
                    <select class="woof_popup_option" data-option="post_links_in_autocomplete">
                        <?php foreach ($post_links_in_autocomplete as $key => $value) : ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

        </div>

        <div class="woof-form-element-container">

            <div class="woof-name-description">
                <strong><?php _e('How to open links with posts in suggestion', 'woocommerce-products-filter') ?></strong>
                <span><?php _e('In the same window (_self) or in the new one (_blank)', 'woocommerce-products-filter') ?></span>
            </div>

            <div class="woof-form-element">
                <?php
                $how_to_open_links = array(
                    0 => __('new window', 'woocommerce-products-filter'),
                    1 => __('the same window', 'woocommerce-products-filter')
                );
                ?>

                <div class="select-wrap">
                    <select class="woof_popup_option" data-option="how_to_open_links">
                        <?php foreach ($how_to_open_links as $key => $value) : ?>
                            <option value="<?php echo $key; ?>"><?php echo $value; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

            </div>

        </div>

    </div>

</li>
