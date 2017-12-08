<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');

final class WOOF_EXT_BY_CUSTOM_SEX extends WOOF_EXT
{

    public $type = 'by_html_type';
    public $html_type = 'by_custom_sex'; //your custom key here
    public $index = 'woof_custom_sex';
    public $html_type_dynamic_recount_behavior = 'none';

    public function __construct()
    {
        parent::__construct();
        $this->init();
    }

    public function get_ext_path()
    {
        return plugin_dir_path(__FILE__);
    }

    public function get_ext_link()
    {
        return plugin_dir_url(__FILE__);
    }

    public function woof_add_items_keys($keys)
    {
        $keys[] = $this->html_type;
        return $keys;
    }

    public function init()
    {
        if ((int) get_option('woof_first_init', 0) != 1)
        {
            update_option('woof_show_custom_sex_search', 0);
        }

        add_filter('woof_add_items_keys', array($this, 'woof_add_items_keys'));
        add_action('woof_print_html_type_options_' . $this->html_type, array($this, 'woof_print_html_type_options'), 10, 1);
        add_action('woof_print_html_type_' . $this->html_type, array($this, 'print_html_type'), 10, 1);
        add_action('wp_head', array($this, 'wp_head'), 999);

        self::$includes['js']['woof_' . $this->html_type . '_html_items'] = $this->get_ext_link() . 'js/' . $this->html_type . '.js';
        self::$includes['css']['woof_' . $this->html_type . '_html_items'] = $this->get_ext_link() . 'css/' . $this->html_type . '.css';
        self::$includes['js_init_functions'][$this->html_type] = 'woof_init_custom_sex';//we have no init function in this case
        //***
        add_shortcode('woof_custom_sex_filter', array($this, 'woof_custom_sex_filter'));
    }

    public function wp_head()
    {
        global $WOOF;
        ?>

        <script type="text/javascript">
            if (typeof woof_lang_custom == 'undefined') {
                var woof_lang_custom = {};//!!important
            }
            woof_lang_custom.<?php echo $this->index ?> = "<?php _e('By sex', 'woocommerce-products-filter') ?>";
        </script>
        <?php
    }

    //shortcode
    public function woof_custom_sex_filter($args = array())
    {
        global $WOOF;
        return $WOOF->render_html($this->get_ext_path() . 'views' . DIRECTORY_SEPARATOR . 'shortcodes' . DIRECTORY_SEPARATOR . 'woof_custom_sex_filter.php', $args);
    }

    //settings page hook
    public function woof_print_html_type_options()
    {
        global $WOOF;
        echo $WOOF->render_html($this->get_ext_path() . 'views' . DIRECTORY_SEPARATOR . 'options.php', array(
            'key' => $this->html_type,
            "woof_settings" => get_option('woof_settings', array())
                )
        );
    }

    public function assemble_query_params(&$meta_query, $wp_query = NULL)
    {
        
		global $WOOF;
        $request = $WOOF->get_request_data();

        if (isset($request['woof_custom_sex']))
        {
			$meta_query[] = array(
				array(
					'key' => 'wc_custom_sex',
					'value' => $request['woof_custom_sex'], //male,female
					//'compare' => 'IN'
				)
			);
        }
        return $meta_query;
    }

}

WOOF_EXT::$includes['html_type_objects']['by_custom_sex'] = new WOOF_EXT_BY_CUSTOM_SEX();
