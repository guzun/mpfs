<?php
class widget_front_submission extends WP_Widget {

	function widget_front_submission() {
	/*Constructor*/
		$widget_ops = array( 'classname' => 'widget_front_submission ', 'description' => __( 'Front end submission Link' , 'twentyfourteen' ) );
		$this->WP_Widget( 'widget_cosmo_front_submission', __( 'MPFS Front end submission' , 'twentyfourteen' ) , $widget_ops );
	}

	function widget( $args , $instance ) {
        /* prints the widget*/

        if( isset( $instance[ 'title' ] ) ){
            $title = $instance[ 'title' ];
        }else{
            $title = '';
        }

        if( isset( $instance[ 'page_url' ] ) ){
            $page_url = $instance[ 'page_url' ];
        }else{
            $page_url = '';
        }
        
        extract( $args , EXTR_SKIP );

        echo $before_widget;

        ?>  
        <div class="mpfs-front-btn">

            <a class="" href="<?php echo $page_url; ?>" target="_blank">
                <span class="genericon genericon-cloud-upload"></span>
                <?php echo $title; ?>
            </a>
        </div>
        <?php

        echo $after_widget;
	}

	function update($new_instance, $old_instance) {

	/*save the widget*/
		$instance = $old_instance;
		$instance['title'] = strip_tags( $new_instance['title'] );
        $instance['page_url'] = strip_tags( $new_instance['page_url'] );

        return $instance;
	}

	function form($instance) {
	/*widgetform in backend*/

		if( isset( $instance[ 'title' ] ) ){
            $title = $instance[ 'title' ];
        }else{
            $title = '';
        }
        if( isset( $instance[ 'page_url' ] ) ){
            $page_url = $instance[ 'page_url' ];
        }else{
            $page_url = '';
        }
        
        
        ?>
            <p>
                <label for="<?php echo $this -> get_field_id( 'title' ); ?>"><?php _e( 'Buton Title' , 'twentyfourteen' ) ?>:
                    <input class="widefat" type="text" id="<?php echo $this -> get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $title; ?>">
                </label>
            </p>

            <p>
                <label for="<?php echo $this -> get_field_id( 'page_url' ); ?>"><?php _e( 'URL For submission page' , 'twentyfourteen' ) ?>:
                    <input class="widefat" type="text" id="<?php echo $this -> get_field_id( 'page_url' ); ?>" name="<?php echo $this->get_field_name( 'page_url' ); ?>" value="<?php echo $page_url; ?>">
                </label>
            </p>
            
        <?php

	}

}
?>