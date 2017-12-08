<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');

global $WOOF;
if (isset($WOOF->settings['by_custom_born_in']) AND $WOOF->settings['by_custom_size']['show'])
{
    if (isset($WOOF->settings['by_custom_size']['title']) AND ! empty($WOOF->settings['by_custom_size']['title']))
    {
        ?>
        <!-- <<?php echo apply_filters('woof_title_tag', 'h4'); ?>><?php echo $WOOF->settings['by_custom_size']['title']; ?></<?php echo apply_filters('woof_title_tag', 'h4'); ?>> -->
        <?php
    }
    echo do_shortcode('[woof_custom_size_filter]');
}


