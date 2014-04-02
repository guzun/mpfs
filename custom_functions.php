<?php
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

			return $feed_info;
	}
?>