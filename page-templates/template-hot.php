<?php
/**
*Template Name: Hot posts all time
 */

get_header(); ?>

<div id="main-content" class="main-content">

<?php
	if ( is_front_page() && twentyfourteen_has_featured_posts() ) {
		// Include the featured content template.
		get_template_part( 'featured-content' );
	}
?>
	<div id="primary" class="content-area">
		<div id="content" class="site-content" role="main">

			<?php

			
							
            $wp_query = new WP_Query( array(
                'post_status' => 'publish' ,
                'post_type' => 'post',
                'paged' => $paged ,
                'meta_key' => 'nr_like' ,
                'orderby' => 'meta_value_num' ,
                //'fp_type' => $fp_type,
                'meta_query' => array(
                        array(
                            'key' => 'nr_like' ,
                            'value' => 1,
                            'compare' => '>=' ,
                            'type' => 'numeric',
                        ) ),
                'order' => 'DESC' ));
				
			
				if ( $wp_query->have_posts() ) :
			
				// Start the Loop.
				while ( $wp_query->have_posts() ) : $wp_query->the_post();

					/*
					 * Include the post format-specific template for the content. If you want to
					 * use this in a child theme, then include a file called called content-___.php
					 * (where ___ is the post format) and that will be used instead.
					 */
					get_template_part( 'content', get_post_format() );

				endwhile;
					// Previous/next post navigation.
					twentyfourteen_paging_nav();
				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'content', 'none' );

				endif;
			?>

		</div><!-- #content -->
	</div><!-- #primary -->
	<?php get_sidebar( 'content' ); ?>
</div><!-- #main-content -->

<?php
get_sidebar();
get_footer();
