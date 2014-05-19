<?php 

return array( 
	
	/*
	|--------------------------------------------------------------------------
	| oAuth Config
	|--------------------------------------------------------------------------
	*/

	/**
	 * Storage
	 */
	'storage' => 'Session', 

	/**
	 * Consumers
	 */
	'consumers' => array(
        'Google' => array(
            'client_id'     => '128979694552-52ocf6pq4vg6c990d2n7bcbc0gr7qdip.apps.googleusercontent.com',
            'client_secret' => 'D5ZTendqaJfIQYV_nfgZ50pl',
            'scope'         => array("userinfo_email", "userinfo_profile"),
        ),		

	)

);