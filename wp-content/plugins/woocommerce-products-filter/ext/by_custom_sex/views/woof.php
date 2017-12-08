<?php

if (!defined('ABSPATH'))
    die('No direct access allowed');

global $WOOF;
if (isset($WOOF->settings['by_custom_sex']))
{
    if ($WOOF->settings['by_custom_sex']['show'])
    {
        if (isset($WOOF->settings['by_custom_sex']['placeholder']))
        {
            WOOF_HELPER::wpml_translate(null, $WOOF->settings['by_custom_sex']['placeholder']);
        }

        //echo do_shortcode('[woof_custom_sex_filter placeholder="' . $placeholder . '"]');
		echo do_shortcode('[woof_custom_sex_filter]');
    }
}

