<?php
if (!defined('ABSPATH'))
    die('No direct access allowed');

//24-04-2017
final class WOOF_EXT_BY_CUSTOM_BORN_IN extends WOOF_EXT {
	
    public $type = 'by_html_type';
    public $html_type = 'by_custom_born_in'; //your custom key here
    public $index = 'woof_custom_born_in';
    public $html_type_dynamic_recount_behavior = 'none';

    public function __construct() {
	parent::__construct();
	$this->init();
	
    }

    public function get_ext_path() {
	return plugin_dir_path(__FILE__);
    }

    public function get_ext_link() {
	return plugin_dir_url(__FILE__);
    }

    public function woof_add_items_keys($keys) {
	$keys[] = $this->html_type;
	return $keys;
    }

    public function init() {
	add_filter('woof_add_items_keys', array($this, 'woof_add_items_keys'));
	add_filter('woof_get_request_data', array($this, 'woof_get_request_data'));
	add_action('woof_print_html_type_options_' . $this->html_type, array($this, 'woof_print_html_type_options'), 10, 1);
	add_action('woof_print_html_type_' . $this->html_type, array($this, 'print_html_type'), 10, 1);
	add_action('wp_head', array($this, 'wp_head'), 999);
	
	add_action('wp_ajax_woof_custom_born_in_autocomplete', array($this, 'woof_custom_born_in_autocomplete'));
	add_action('wp_ajax_nopriv_woof_custom_born_in_autocomplete', array($this, 'woof_custom_born_in_autocomplete'));

	self::$includes['js']['woof_' . $this->html_type . '_html_items'] = $this->get_ext_link() . 'js/' . $this->html_type . '.js';
	self::$includes['css']['woof_' . $this->html_type . '_html_items'] = $this->get_ext_link() . 'css/' . $this->html_type . '.css';
	self::$includes['js_init_functions'][$this->html_type] = 'woof_init_custom_born_in'; //we have no init function in this case*/
	//***
	add_shortcode('woof_custom_born_in_filter', array($this, 'woof_custom_born_in_filter')); 
    }

    public function woof_get_request_data($request) {
		
	if (isset($request['s'])) {
		
	    $request['woof_custom_born_in'] = $request['s'];
	    //unset($request['s']);
	}

	return $request;
    }

    public function wp_head() {
	global $WOOF;
	//***
	//var_dump($WOOF->settings['by_custom_born_in']);
	if (isset($WOOF->settings['by_custom_born_in']['autocomplete']) AND $WOOF->settings['by_custom_born_in']['autocomplete']) {
	    wp_enqueue_script('easy-autocomplete', WOOF_LINK . 'js/easy-autocomplete/jquery.easy-autocomplete.min.js', array('jquery'));
	    wp_enqueue_style('easy-autocomplete', WOOF_LINK . 'js/easy-autocomplete/easy-autocomplete.min.css');
	    wp_enqueue_style('easy-autocomplete-theme', WOOF_LINK . 'js/easy-autocomplete/easy-autocomplete.themes.min.css');
	}
	?>
	<style type="text/css">
	<?php
	if (isset($WOOF->settings['by_custom_born_in']['image'])) {
	    if (!empty($WOOF->settings['by_custom_born_in']['image'])) {
		?>
		    .woof_custom_born_in_search_container .woof_custom_born_in_search_go{
			background: url(<?php echo $WOOF->settings['by_custom_born_in']['image'] ?>) !important;
		    }
		<?php
	    }
	}
	?>
	</style>
	<script type="text/javascript">
	    if (typeof woof_lang_custom == 'undefined') {
		var woof_lang_custom = {};//!!important
	    }
	    woof_lang_custom.<?php echo $this->index ?> = "<?php _e('By born', 'woocommerce-products-filter') ?>";

	    var woof_custom_born_in_autocomplete = 0;
	    var woof_custom_born_in_autocomplete_items = 10;
	<?php if (isset($WOOF->settings['by_custom_born_in']['autocomplete'])): ?>
	        woof_custom_born_in_autocomplete =<?php echo (int) $WOOF->settings['by_custom_born_in']['autocomplete']; ?>;
	        woof_custom_born_in_autocomplete_items =<?php echo apply_filters('woof_custom_born_in_autocomplete_items', 10) ?>;
	<?php endif; ?>

	    var woof_post_links_in_autocomplete = 0;
	<?php if (isset($WOOF->settings['by_custom_born_in']['post_links_in_autocomplete'])): ?>
	        woof_post_links_in_autocomplete =<?php echo (int) $WOOF->settings['by_custom_born_in']['post_links_in_autocomplete']; ?>;
	<?php endif; ?>

	    var how_to_open_links = 0;
	<?php if (isset($WOOF->settings['by_custom_born_in']['how_to_open_links'])): ?>
	        how_to_open_links =<?php echo (int) $WOOF->settings['by_custom_born_in']['how_to_open_links']; ?>;
	<?php endif; ?>

	</script>
	<?php
    }

    //shortcode
    public function woof_custom_born_in_filter($args = array()) {
	global $WOOF;
	$args['loader_img'] = $this->get_ext_link() . 'img/loader.gif';
	return $WOOF->render_html($this->get_ext_path() . 'views' . DIRECTORY_SEPARATOR . 'shortcodes' . DIRECTORY_SEPARATOR . 'woof_custom_born_in_filter.php', $args);
    }

    //settings page hook
    public function woof_print_html_type_options() {
	global $WOOF;
	echo $WOOF->render_html($this->get_ext_path() . 'views' . DIRECTORY_SEPARATOR . 'options.php', array(
	    'key' => $this->html_type,
	    "woof_settings" => get_option('woof_settings', array())
		)
	);
    }

    public function assemble_query_params(&$meta_query, $wp_query = NULL) {

		global $WOOF;
        $request = $WOOF->get_request_data();
        if (isset($request['woof_custom_born_in']))
        {
            $meta_query[] = array(
                'key' => 'wc_custom_born_in',
                'value' => $request['woof_custom_born_in'],
                //'type' => 'CHAR',
                //'compare' => 'BETWEEN'
            );
        }                       

	  return $meta_query;
    }

    public function woof_post_text_filter($where = '') {
	global $wp_query;
	global $WOOF;
	$request = $WOOF->get_request_data();

	//***

	if (isset($request['s'])) {
	    //uncomment it for cyrillic text search
	    //return $where;
	}

	//***      


	if (defined('DOING_AJAX')) {
	    $conditions = (isset($wp_query->query_vars['post_type']) AND $wp_query->query_vars['post_type'] == 'product') OR isset($_REQUEST['woof_products_doing']);
	} else {
	    $conditions = isset($_REQUEST['woof_products_doing']);
	}
	

		//$where .= " AND ( " . $text_where . " )";
		//$where .= " AND ( meta_key = 'wc_custom_born_in' AND meta_value = " . $woof_custom_born_in . " )";

        if (isset($request['woof_custom_born_in'])) {
		       $meta_query[] = array(
                    array(
                        'key' => 'wc_custom_born_in',
                        'value' => $woof_custom_born_in, //instock,outofstock
                        //'compare' => 'IN'
                    )
                );
        }

                        /*$args = array(
                            'nopaging' => true,
                            'suppress_filters' => true,
                            'post_status' => 'publish',
                            'post_type' => array('product'),
                            'meta_query' => $meta_query
                        );

                        //print_r($meta_query);exit;
                        //$query = new WP_Query(array_merge($args, array('fields' => 'ids')));
                        $query = new WP_Query($args);
						//print_r($query->request);exit;
                        $products = array();
                        if ($query->have_posts())
                        {
                            foreach ($query->posts as $p)
                            {
                                $products[$p->post_parent] = $p->post_parent;
                            }
                        }
                        $product_ids = implode(',', $products);
                        echo $product_ids;	die;
                        //exit;

                        if (!empty($product_ids))
                        {
                            $where .= " AND $wpdb->posts.ID NOT IN($product_ids)";
                        } */
	//***
	//print "<pre>"; print_r($wp_query); print "</pre>"; die;
	return $where;
    }



    //ajax
    public function woof_custom_born_in_autocomplete() {

		$_GET['woof_custom_born_in'] = $_REQUEST['phrase'];
	$meta_query[] = array(
                    array(
                        'key' => 'wc_custom_born_in',
                        'value' => $_REQUEST['phrase'], //instock,outofstock
                        //'compare' => 'IN'
                    )
                );	

	$results = array();
	$args = array(
	    'nopaging' => true,
	    //'fields' => 'ids',
	    'post_type' => 'product',
	    'post_status' => array('publish'),
	    'meta_query' => $meta_query,
	    'orderby' => 'title',
	    'order' => 'ASC',
	    'max_num_pages' => intval($_REQUEST['auto_res_count']) > 0 ? intval($_REQUEST['auto_res_count']) : apply_filters('woof_custom_born_in_autocomplete_items', 10)
	);

	if (class_exists('SitePress')) {
	    $args['lang'] = ICL_LANGUAGE_CODE;
	}

	//***
	// $meta_query = array('relation' => 'AND');
	
	//add_filter('posts_where', array($this, 'woof_post_text_filter'), 10);
	//print "<pre>"; print_r($args); print "</pre>"; die;
	$query = new WP_Query($args);
	//+++
	//http://easyautocomplete.com/guide
	if ($query->have_posts()) {
	    include_once WOOF_PATH . 'lib' . DIRECTORY_SEPARATOR . 'aq_resizer.php';
	    $tmp = array();
	    foreach ($query->posts as $p) {
		if (!in_array($p->post_title, $tmp)) {
		    $tmp[] = $p->post_title;
		    $data = array(
			"name" => $p->post_title,
			"type" => "product",
			//
		    );
		    if (has_post_thumbnail($p->ID)) {
			$img_src = wp_get_attachment_image_src(get_post_thumbnail_id($p->ID), 'single-post-thumbnail');
			$data['icon'] = woof_aq_resize($img_src[0], 100, 100, true);
		    } else {
			$data['icon'] = WOOF_LINK . 'img/not-found.jpg';
		    }
		    $data['link'] = get_post_permalink($p->ID);
		    $results[] = $data;
		}
	    }
	} else {
	    $results[] = array(
		"name" => __("Products not found!", 'woocommerce-products-filter'),
		"type" => "",
		"link" => "#",
		"icon" => WOOF_LINK . 'img/not-found.jpg'
	    );
	}

	die(json_encode($results));
    }

}

WOOF_EXT::$includes['html_type_objects']['by_custom_born_in'] = new WOOF_EXT_BY_CUSTOM_BORN_IN();
