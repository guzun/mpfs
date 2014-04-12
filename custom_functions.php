<?php


	function mpfs__autoload( $class_name ){ //echo $class_name .'<br>';
        if( substr( $class_name , 0 , 6 ) == 'widget'){
            $class_name = str_replace( 'widget_' , '' ,  $class_name );
            if( is_file( get_template_directory() . '/inc/custom-widgets/' . $class_name . '.php' ) ){
                include get_template_directory() . '/inc/custom-widgets/' . $class_name . '.php';

            }
        }
		
	}

	spl_autoload_register ("mpfs__autoload");

	// Create a new filtering function that will add our where clause to the query
	function filter_where_07( $where = '' ) {
		// posts in the last 30 days
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-7 days')) . "'";
		return $where;
	}	
	
	function filter_where_30( $where = '' ) {
		// posts in the last 30 days
		$where .= " AND post_date > '" . date('Y-m-d', strtotime('-30 days')) . "'";
		return $where;
	}	

	function mpfs_get_feed_info(){

		// get the App info from options
		// if requires Advanced Custom fields installed together with Repeter and Options Page extentions
		if(function_exists('get_field')){
			$feed_info = get_field('feed_info','option'); 	
		}else{
			$feed_info = '';
		}
		

		// fallback in case the data is not acailable from options
		if(!is_array($feed_info)){
			$feed_info = array( array('title' => "Appli PAC : Putain d'Autocorrection !",
									'small_icon' => "http://www.mesparentsfontdessms.com/wp-content/uploads/2013/11/pac-small.png",
									'big_icon' =>"http://www.mesparentsfontdessms.com/wp-content/uploads/2013/11/PAC-big.png",
									'ios_url' => "https://itunes.apple.com/fr/app/p*****-dautocorrection-sms-!/id615982234?mt=8",
									'android_url' => ""),

							array('title' => "Suivez-nous sur Facebook !",
									'small_icon' => "http://www.mesparentsfontdessms.com/wp-content/uploads/2013/11/facebook-small.png",
									'big_icon' =>"http://www.mesparentsfontdessms.com/wp-content/uploads/2013/11/FB-big.png",
									'ios_url' => "https://www.facebook.com/MesParentsFontdesSMS?ref=hl",
									'android_url' => "https://www.facebook.com/MesParentsFontdesSMS?ref=hl"),

							array('title' => "Suivez-nous sur Twitter !",
									'small_icon' => "http://www.mesparentsfontdessms.com/wp-content/uploads/2013/11/twitter-small.png",
									'big_icon' =>"http://www.mesparentsfontdessms.com/wp-content/uploads/2013/11/twitter-big.png",
									'ios_url' => "https://twitter.com/mpfs1",
									'android_url' => "https://twitter.com/mpfs1"),

							array('title' => "Chers Voisins :)",
									'small_icon' => "http://www.mesparentsfontdessms.com/wp-content/uploads/2013/11/chers-voisin-small.png",
									'big_icon' =>"http://www.mesparentsfontdessms.com/wp-content/uploads/2013/11/chers-voisin-big.png",
									'ios_url' => "http://chersvoisins.net/",
									'android_url' => "http://chersvoisins.tumblr.com/"),

			);
		}
		

			return $feed_info;
	}

	/*action hook for the site copyright*/
	add_action('twentyfourteen_credits','mpfs_copyright');

	function mpfs_copyright(){

		echo 'MPFS | Copyright © '.date('Y').'. Tous droits réservés. <a href="http://www.socialcooking.fr" target="_blank">Blog Cuisine</a> | <a href="http://www.voyage-et-decouvertes.com" target="_blank">Blog Voyage</a>';
	}
	
	/* gets a random post and returns its URL */
	function random_posts(){
        
        $wp_query = new WP_Query( array( 'post_status' => 'publish' ,'post_type' => 'post' , 'posts_per_page' => 1 , 'orderby' => 'rand'   ) );

        if( $wp_query -> found_posts > 0 ){
            $k = 0;
            foreach( $wp_query -> posts as $post  ){
                $wp_query -> the_post();
                $result = get_permalink( $post -> ID );
            }
        }

        echo $result;
        exit;
       
    }	

    /* related posts by herarchical taxonomy */
    /* get tax slugs and number of similar posts  */ 
    function similar_query( $post_id , $taxonomy , $nr ){
        if( $nr > 0 ){
            $topics = wp_get_post_terms( $post_id , $taxonomy );

            $terms = array();
            if( !empty( $topics ) ){
                foreach ( $topics as $topic ) {
                    $term = get_category( $topic );
                    array_push( $terms, $term -> slug );
                }
            }

            if( !empty( $terms ) ){
                $query = new WP_Query( array(
                    'post__not_in' => array( $post_id ) ,
                    'posts_per_page' => $nr,
                    'orderby' => 'rand',
                    'tax_query' => array(
                        array(
                        'taxonomy' => $taxonomy ,
                        'field' => 'slug',
                        'terms' => $terms ,
                        )
                    )
                ));
            }else{
                $query = array();
            }
        }else{
            $query = array();
        }

        return $query;
    }		


    register_widget("widget_category_icons");	

    register_widget("widget_front_submission");	
				
?>