<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');

global $WOOF;
if (isset($WOOF->settings['by_custom_breeder']) AND $WOOF->settings['by_custom_breeder']['show'])
{
    if (isset($WOOF->settings['by_custom_breeder']['title']) AND ! empty($WOOF->settings['by_custom_breeder']['title']))
    {
        ?>
        <!-- <<?php echo apply_filters('woof_title_tag', 'h4'); ?>><?php echo $WOOF->settings['by_custom_breeder']['title']; ?></<?php echo apply_filters('woof_title_tag', 'h4'); ?>> -->
        <?php
    }
    echo do_shortcode('[woof_custom_breeder_filter]');
}


