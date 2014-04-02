<?php echo '<?xml version="1.0" encoding="'.get_option('blog_charset').'"?'.'>'; ?>


<note>

	<?php  
		//$feed = options::get_value( '_feed' );
		$feed = mpfs_get_feed_info();
		
		if(sizeof($feed)){
			foreach ($feed as $key => $feed_info) {
	?>
			<appinfo>
				<title><?php echo strlen($feed_info['title']) ? stripslashes( $feed_info['title'] ) : 0;  ?></title>
				<small_icon><?php echo strlen($feed_info['small_icon']) ? $feed_info['small_icon']: 0; ?></small_icon>
				<big_icon><?php echo strlen($feed_info['big_icon']) ? $feed_info['big_icon'] : 0; ?></big_icon>
				<ios_url><?php echo strlen($feed_info['ios_url']) ? $feed_info['ios_url'] : 0; ?></ios_url>
				<android_url><?php echo strlen($feed_info['android_url']) ? $feed_info['android_url']: 0;  ?></android_url>
			</appinfo>
	<?php			
			}
		}
	?>
	

</note>

