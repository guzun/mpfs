<?php
    

    /* post taxonomy */
    $tax = 'category';
    
    
    $nr = 3;
    
    $label  = __( 'Tu vas aussi kiffer :' , 'twentyfourteen' );
    $query  = similar_query( $post -> ID , $tax , $nr );
    

    if( !empty( $query ) ){
        if( $query -> found_posts < $nr ){
            $nr = $query -> found_posts;
        }

        $result = $query -> posts;
    }
        


    

    if( !empty( $result) ){
?>
        <div class="box-related clearfix">
            <h3 class="related-title"><?php _e( 'Tu vas aussi kiffer :' , 'twentyfourteen' ); ?></h3>
            <!-- <p class="delimiter">&nbsp;</p> -->
            <div>
            <?php
                
                $div = 3;
                $size   = '170x100';
                
                $i = 1;
                $k = 1;

                foreach( $result as $similar ){
                    if( $i == 1 ){
                        if( ( $nr - $k ) < $div  ){
                            $classes = 'class="last"';
                        }else{
                            $classes = '';
                        }
                        echo '<div ' . $classes . '>';
                    }

                  
                
                    /* featured image */
                    $text = '';
                    $image = '';

                    if( has_post_thumbnail( $similar -> ID ) ){

                        $image = wp_get_attachment_image( get_post_thumbnail_id( $similar -> ID ) , $size );

                        $img = get_post( get_post_thumbnail_id( $similar -> ID ) );

                        if( !empty( $images ) ){
                            $text = $img -> post_excerpt;
                        }else{
                            $text = '';
                        }

                    }else{
                        $image = '<img src="' . get_template_directory_uri() . '/images/no.image.' . $size . '.png" />';
                    }

                    /*  related presentation */
                ?>
                <article  id="post-<?php echo $similar -> ID; ?>" class="col format-<?php echo strlen( get_post_format( $similar -> ID ) ) ? get_post_format( $similar -> ID ) : 'standard'; ?>">
                        <?php
                            if( strlen( $image ) ){
                        ?>
                                <div class="readmore related">
                                    <?php
                                        $cnt_a = ' class="mosaic-overlay" href="' . get_permalink( $similar -> ID ) . '"';
                                    ?>
                                    <a <?php echo $cnt_a; ?>>
                                        <div class="details">&nbsp;</div>
                                    </a>
									<?php echo '<a href="'.get_permalink( $similar -> ID ).'">' . $image . '</a>'; ?>
                                </div>
                                
                        <?php
                            }
                        ?>
                        <h4>
                            <?php
                                ?><a class="readmore" href="<?php echo get_permalink( $similar -> ID ) ?>"><?php echo mb_substr( $similar -> post_title , 0 , 50 ); ?></a><?php
                            ?>
                        </h4>
                        
                    </article>
                    <?php
                        if( $i % $div == 0 ){
                            echo '</div>';
                            $i = 0;
                        }
                        $i++;
                        $k++;
                    ?>
            <?php
                }

            /* if div container is open */
            if( $i > 1 ){
                echo '</div>';
            }

            ?>
        </div> <!--  end container related posts -->
    </div>
<?php

        wp_reset_postdata();
    }
?>