<?php get_header(); ?>
 
<div id="main-content">
    <div class="container">
        <div id="content-area" class="clearfix">
        
            <div id="left-area">
                <article id="post-0" <?php post_class( 'et_pb_post not_found' ); ?>>
                       <?php     
                      $request = $_SERVER['REQUEST_URI'];
			if (strpos($request, 'product') !== false) {
			
   			echo '<h1>Please Log in or Register</h1> <p>You must be logged in to view products and prices on this site.</p>';
   			echo '<div class="register"><a href="/shop/wholesale/?product_from='.$request.'" id="register-ws">Register as a Wholesale Buyer / Dealer</a> | <a id ="register-ac" href="/shop/my-account/?product_from='.$request.'">Register for Koi Auction</a>';
   			} else { ?>
                    <h1><?php esc_html_e('Page Not Found','Divi'); ?></h1>
                    <p><?php esc_html_e('Whoops. Looks like the page you were looking for doesn\'t exit. Maybe try searching for something else using the search bar above', 'Divi'); ?></p>
                    
                  			<?php  }
                  			?>
                </article> <!-- .et_pb_post -->
            </div> <!-- #left-area -->
 			

            <?php dynamic_sidebar( '404 Error Page' ); ?>

        </div> <!-- #content-area -->
    </div> <!-- .container -->
</div> <!-- #main-content -->
 
<?php get_footer(); ?>