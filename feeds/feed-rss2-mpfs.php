<?php

/**

 * RSS2 Feed Template for displaying RSS2 Posts feed.

 *

 * @package WordPress

 */



header('Content-Type: ' . feed_content_type('rss-http') . '; charset=' . get_option('blog_charset'), true);

$more = 1;
//wp_reset_query();


echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>



<rss version="2.0"

	xmlns:content="http://purl.org/rss/1.0/modules/content/"

	xmlns:wfw="http://wellformedweb.org/CommentAPI/"

	xmlns:dc="http://purl.org/dc/elements/1.1/"

	xmlns:atom="http://www.w3.org/2005/Atom"

	xmlns:sy="http://purl.org/rss/1.0/modules/syndication/"

	xmlns:slash="http://purl.org/rss/1.0/modules/slash/"

	<?php do_action('rss2_ns'); ?>

>



<channel>

	<title><?php bloginfo_rss('name'); wp_title_rss(); ?></title>

	<atom:link href="<?php self_link(); ?>" rel="self" type="application/rss+xml" />

	<link><?php bloginfo_rss('url') ?></link>

	<description><?php bloginfo_rss("description") ?></description>

	<lastBuildDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false); ?></lastBuildDate>

	<language><?php echo get_option('rss_language'); ?></language>

	<sy:updatePeriod><?php echo apply_filters( 'rss_update_period', 'hourly' ); ?></sy:updatePeriod>

	<sy:updateFrequency><?php echo apply_filters( 'rss_update_frequency', '1' ); ?></sy:updateFrequency>

	<?php do_action('rss2_head'); 
		if(isset($_GET[ 'page' ]) && is_numeric($_GET[ 'page' ])){
			$paged = $_GET[ 'page' ];
		}else{
			$paged = 1;
		}
		

		if(isset($_GET[ 'pp' ]) && is_numeric($_GET[ 'pp' ])){
			$posts_per_page = $_GET[ 'pp' ];
		}else{
			$posts_per_page = get_option('posts_per_rss');
			//$posts_per_page = -1;
		}
		
		if( isset( $_GET[ 'fp_type' ] ) ){

			
			

			if($_GET[ 'fp_type' ] == 'hot'){

				$wp_query = new WP_Query( array(

						'post_status' => 'publish' ,

						'paged' => $paged ,

						'posts_per_page' => $posts_per_page, 

						'meta_key' => 'nr_like' ,

						'orderby' => 'meta_value_num' ,

						'fp_type' => 'hot',

						'meta_query' => array(

								array(

									'key' => 'nr_like' ,

									'value' => 10,

									'compare' => '>=' ,

									'type' => 'numeric',

								) ),

						'order' => 'DESC' )); //var_dump($wp_query);

			}

			

			if($_GET[ 'fp_type' ] == 'hot_7'){ 

				add_filter( 'posts_where', 'filter_where_07' );

				$wp_query = new WP_Query( array(

						'post_status' => 'publish' ,

						'paged' => $paged ,

						'posts_per_page' => $posts_per_page, 

						'meta_key' => 'nr_like' ,

						'orderby' => 'meta_value_num' ,

						'fp_type' => 'hot',

						'meta_query' => array(

								array(

									'key' => 'nr_like' ,

									'value' => 10 ,

									'compare' => '>=' ,

									'type' => 'numeric',

								) ),

						'order' => 'DESC' )); //var_dump($wp_query);

			}

			

			if($_GET[ 'fp_type' ] == 'hot_30'){

				add_filter( 'posts_where', 'filter_where_30' );

				$wp_query = new WP_Query( array(

						'post_status' => 'publish' ,

						'paged' => $paged ,

						'posts_per_page' => $posts_per_page, 

						'meta_key' => 'nr_like' ,

						'orderby' => 'meta_value_num' ,

						'fp_type' => 'hot',

						'meta_query' => array(

								array(

									'key' => 'nr_like' ,

									'value' => 10 ,

									'compare' => '>=' ,

									'type' => 'numeric',

								) ),

						'order' => 'DESC' )); //var_dump($wp_query);

			}

			if( $_GET[ 'fp_type' ] == 'random'){  

				if( isset($_GET[ 'number_posts' ] ) && is_numeric($_GET[ 'number_posts' ]) ){  
					$nrposts = $_GET[ 'number_posts' ];
				}else{
					$nrposts = 1;
				}

				

				$wp_query = new WP_Query( array(

						'post_status' => 'publish' ,

						'paged' => $paged ,

						'posts_per_page' => $nrposts,

						'orderby' => 'rand' 

						 ));

			}			

		}else{

			$query_args_array = array(

						'post_status' => 'publish' ,

						'paged' => $paged ,

						'posts_per_page' => $posts_per_page
						);

			if(isset($_GET['category_name']) && strlen($_GET['category_name'])){
				$query_args_array['category_name'] = $_GET['category_name'];
			}
			
			$wp_query = new WP_Query( $query_args_array ); //var_dump($wp_query);
		}			
		//deb::e($wp_query);
//wp_mail('guzun.allex@gmail.com', 'testtik_hattab' , var_export($wp_query,true));
	?>

	<?php while( have_posts()) : the_post(); ?>

	<item>

		<title><?php the_title_rss() ?></title>

		<link><?php the_permalink_rss() ?></link>

		
		<?php

			$args = array(

				'number' => 10,

				'post_id' => $post->ID,

				'status' => 'approve',

			);

	 ?>

		<pubDate><?php echo mysql2date('D, d M Y H:i:s +0000', get_post_time('Y-m-d H:i:s', true), false); ?></pubDate>

		<dc:creator><?php the_author() ?></dc:creator>

		<?php //the_category_rss('rss2') ?>



		<guid isPermaLink="false"><?php the_guid(); ?></guid>

<?php if (get_option('rss_use_excerpt')) : ?>

		<!--<description><![CDATA[<?php //the_excerpt_rss() ?>]]></description>-->

<?php else : ?>

		

	<?php if ( strlen( $post->post_content ) > 0 ) : ?>

		<content:encoded><![CDATA[<?php the_content_feed('rss2') ?>]]></content:encoded>

	<?php else : ?>

		<content:encoded><![CDATA[<?php the_excerpt_rss() ?>]]></content:encoded>

	<?php endif; ?>

	<likes><?php echo sizeof(get_post_meta( $post->ID , 'like' )); ?></likes>

<?php endif; ?>

		

<?php rss_enclosure(); ?>

	<?php do_action('rss2_item'); ?>

	</item>

	<?php endwhile; ?>

</channel>

</rss>