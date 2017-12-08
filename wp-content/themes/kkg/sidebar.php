<?php
if ( ( is_single() || is_page() ) && 'et_full_width_page' === get_post_meta( get_queried_object_id(), '_et_pb_page_layout', true ) )
	return;
 if ( is_active_sidebar( 'et_pb_widget_area_1' )  && (is_singular('qa_faqs') | is_tax('faq_category') )  ) { ?>
<div id="sidebar">
<?php dynamic_sidebar( 'et_pb_widget_area_1' ); ?>
</div> <!-- end FAQs #sidebar -->
<?php } else if ( is_active_sidebar( 'et_pb_widget_area_3' ) && (is_singular('champion-koi') | is_tax('project_category') | is_tax('project_tag') ) ) { ?>
<div id="sidebar">
<?php dynamic_sidebar( 'et_pb_widget_area_3' ); ?>
</div> <!-- end Koi #sidebar -->
<?php } else if ( is_active_sidebar( 'et_pb_widget_area_4' ) && (is_single() | is_archive('category'))) { ?>
<div id="sidebar">
<?php dynamic_sidebar( 'et_pb_widget_area_4' ); ?>
</div> <!-- end Blog #sidebar -->
<?php }else 
if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
	<div id="sidebar">
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	</div> <!-- end #sidebar -->
<?php endif; ?>

