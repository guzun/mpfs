<?php
    class like{
        
        static function set( $post_id = 0 ){

            if( $post_id == 0 ){
                $post_id = isset( $_POST['post_id' ]) ? (int) $_POST['post_id'] : exit;
                $ajax = true;
            }else{
                $ajax = false;
            }


            $likes = get_post_meta( $post_id , 'like', true );

            

            $user       = true;
            $user_ip    = true;

            $ip     = $_SERVER['REMOTE_ADDR'];

            if( is_user_logged_in () ){
                $user_id = get_current_user_id();
            }else{
                $user_id = 0;
            }
            if ( is_array($likes)) {
                if( $user_id > 0 ){
                    /* like by user */
                    foreach( $likes as  $like ){
                        if( isset( $like['user_id'] ) && $like['user_id'] == $user_id ){
                           $user   = false;
                           $user_ip = false;
                        }
                    }
                }else{
                    
                    foreach( $likes as  $like ){
                        if( isset( $like['ip'] ) && ( $like['ip'] == $ip ) ){
                            $user = false;
                            $user_ip = false;
                        }
                    }
                }
            };

            if( $user && $user_ip ){
                /* add like */
                $likes[] = array( 'user_id' => $user_id , 'ip' => $ip );
                update_post_meta( $post_id , 'nr_like' , count( $likes ) );
                update_post_meta( $post_id , 'like' ,  $likes );

                //self::attachUserVote($post_id); /*add this post to user's voted_posts meta*/
                
               /* $date = get_post_meta( $post_id , 'hot_date', true );
                if( empty( $date ) ){
                    if( ( count( $likes ) >= 10 ) ){
                       update_post_meta( $post_id , 'hot_date' , time() );
                    }
                }else{
                    if( ( count( $likes ) < 10 ) ){
                        delete_post_meta( $post_id, 'hot_date' );
                    }
                }*/
            }else{
                /* delete like */
                if( $user_id > 0 ){
                    foreach( $likes as $index => $like ){
                        if( isset( $like['user_id'] ) && $like['user_id'] == $user_id ){
                            unset( $likes[ $index ] );
                        }
                    }
                }else{
                    
                    foreach( $likes as $index => $like ){
                        if( isset( $like['ip'] ) && isset( $like['user_id'] ) && ( $like['ip'] == $ip ) && ( $like['user_id'] == 0 ) ){
                            unset( $likes[ $index ] );
                        }
                    }
                }
                
                
                update_post_meta( $post_id , 'like' ,  $likes );
                update_post_meta( $post_id , 'nr_like' ,  count( $likes ) );
                /*if( count( $likes ) < 10 ){
                    delete_post_meta($post_id, 'hot_date' );
                }*/
            }

            if( $ajax ){
                echo (int)count( $likes );
                exit;
            }
        }

        static function is_voted( $post_id ){
            $ip     = $_SERVER['REMOTE_ADDR'];

            $likes = get_post_meta( $post_id , 'like', true );

            if( is_user_logged_in () ){
                $user_id = get_current_user_id();
            }else{
                $user_id = 0;
            }

            if(sizeof($likes) && is_array($likes)){
                if( $user_id > 0 ){
                    foreach( $likes as $like ){
                        if( isset( $like['user_id'] ) && $like['user_id'] == $user_id ){
                            return true;
                        }
                    }
                }else{
                    foreach( $likes as $like ){
                        if( isset( $like['ip'] ) && $like['ip'] == $ip ){
                            return true;
                        }
                    }
                }
            }
            

            return false;
        }

        static function can_vote( $post_id ){
            $ip     = $_SERVER['REMOTE_ADDR'];

            $likes = get_post_meta( $post_id , 'like', true );

            if( is_user_logged_in () ){
                $user_id = get_current_user_id();
            }else{
                $user_id = 0;
            }

            
            if( $user_id == 0 && is_array($likes)){
                foreach( $likes as $like ){
                    if( isset( $like['user_id'] ) && $like['user_id'] > 0  && $like['ip'] == $ip ){
                        return false;
                    }
                }
            }

            return true;
        }

        static function reset_likes(){
            global $wp_query;
            $paged      = isset( $_POST['page']) ? $_POST['page'] : exit;
            $wp_query = new WP_Query( array('posts_per_page' => 150 , 'post_type' => array( 'post', 'gallery') , 'paged' => $paged ) );
            

            foreach( $wp_query -> posts as $post ){
                delete_post_meta($post -> ID, 'nr_like' );
                delete_post_meta($post -> ID, 'like' );
                /*delete_post_meta($post -> ID, 'hot_date' );*/
            }
            
            if( $wp_query -> max_num_pages >= $paged ){
                if( $wp_query -> max_num_pages == $paged ){
                    echo 0;
                }else{
                    echo $paged + 1;
                }
            }
            
            exit();
        }

        static function sim_likes(){
            global $wp_query;
            $paged      = isset( $_POST['page']) ? $_POST['page'] : exit;
            $wp_query = new WP_Query( array('posts_per_page' => 150 , 'post_type' => array('post','gallery'),  'paged' => $paged ) );
            

            foreach( $wp_query -> posts as $post ){
                $likes = array();
                $ips = array();
                $nr = rand( 60 , 200 );
                while( count( $likes ) < $nr ){
                    $ip = rand( -255 , -100 ) .  rand( -255 , -100 )  . rand( -255 , -100 ) . rand( -255 , -100 );

                    $ips[ $ip ] = $ip;

                    if( count( $ips )  > count( $likes ) ){
                        $likes[] = array( 'user_id' => 0 , 'ip' => $ip );
                    }
                }

                update_post_meta( $post -> ID , 'nr_like' , count( $likes ) );
                update_post_meta( $post -> ID , 'like' ,  $likes );
                /*update_post_meta( $post -> ID , 'hot_date' , time() );*/
            }
            
            if( $wp_query -> max_num_pages >= $paged ){
                if( $wp_query -> max_num_pages == $paged ){
                    echo 0;
                }else{
                    echo $paged + 1;
                }
            }
            
            exit();
        }
        
        /*static function min_likes(){
            global $wp_query;
            $new_limit  = isset( $_POST['new_limit']) ? $_POST['new_limit'] : exit;
            $paged      = isset( $_POST['page']) ? $_POST['page'] : exit;

            $wp_query = new WP_Query( array('posts_per_page' => 150 , 'post_type' => 'post' , 'paged' => $paged ) );
            foreach( $wp_query -> posts as $post ){
                $likes = meta::get_meta( $post -> ID , 'like' );
                meta::set_meta( $post -> ID , 'nr_like' , count( $likes ) );
                if( count( $likes ) < (int)$new_limit ){
                    delete_post_meta( $post -> ID, 'hot_date' );
                }else{
                    if( (int)meta::get_meta( $post -> ID , 'hot_date' ) > 0 ){

                    }else{
                        meta::set_meta( $post -> ID , 'hot_date' , time() );
                    }
                }
            }
            if( $wp_query -> max_num_pages >= $paged ){
                if( $wp_query -> max_num_pages == $paged ){
                    $general = options::get_value( 'general' );
                    $general['min_likes'] = $new_limit;
                    update_option( 'general' , $general );
                    echo 0;
                }else{
                    echo $paged + 1;
                }
            }

            exit();
        }*/

        static function count( $post_id ){
            $result = get_post_meta( $post_id , 'like', true );
            if(is_array($result)){
                return count( $result );    
            }else{
                return 0;
            }
            
        }

        static function content( $post_id , $return = false,$show_icon = true, $show_label = false, $additional_class = '' ){
            if( $return ){
                ob_start();
                ob_clean();
            }
            $post = get_post( $post_id );
            
                $meta = get_post_meta( $post -> ID  , 'settings', true );

                if( !like::can_vote( $post -> ID ) ){
                    $li_click = "get_login_box('like')";
                }

                //$icon_type = options::get_value( 'likes' , 'icons' ); /*for example heart, star or thumbs*/    

                if( isset( $meta['love'] ) ){
                    
?>
                        <span
                            <?php 
                                if( like::can_vote( $post -> ID ) ){
                                    echo "onclick=\"javascript:act.like(" . $post -> ID . ", '.like-" . $post -> ID . "'  );\"";

                                }else{
                                    echo 'onclick="'.$li_click.'"';
                                }
                            ?>

                            class="meta-likes like ilove set-like voteaction <?php if( !like::can_vote( $post -> ID ) ){ echo "simplemodal-love"; }?>
                                    <?php
                                        if( like::is_voted( $post -> ID ) ){
                                            echo 'voted';
                                        }
                                    ?>"
                            >
                            <?php if($show_icon){ ?>
                                <em class="like-btn icon-like-empty">
                                    <?php //if($show_label){ echo options::get_value( 'likes' , 'label' ); } ?>
                                </em>
                                
                            <?php } ?>

                           
                            <i class="like-count like-<?php echo $post -> ID; ?>"><?php echo self::count( $post -> ID ); ?></i>
                           
                        </span>
<?php
                    
                }else{
?>
                    <span
                        <?php
                            if( like::can_vote( $post -> ID ) ){
                                echo "onclick=\"javascript:act.like(" . $post -> ID . ", '.like-" . $post -> ID . "'  );\"";

                            }else{
                                echo 'onclick="'.$li_click.'"';
                            }
                        ?>

                        class="meta-likes like ilove set-like voteaction <?php if( !like::can_vote( $post -> ID ) ){ echo "simplemodal-love"; }?>
                                <?php
                                    if( like::is_voted( $post -> ID ) ){
                                        echo 'voted';
                                    } ?>"
                        >
                        <?php if($show_icon){ ?>
                            <em class="like-btn icon-like-empty">
                                <?php //if($show_label){ echo options::get_value( 'likes' , 'label' ); } ?>
                            </em>
                        <?php } ?>
                        
                        <i class="like-count like-<?php echo $post -> ID; ?>"><?php echo self::count( $post -> ID ); ?></i>
                        
                    </span>
<?php
                }
            
            
            if( $return ){
                $result = ob_get_clean();
                return $result;
            }
        }
        
    }
?>