<?php

function wpp_premium_aweber_settings_page() {

	$settings = wpp_get_settings();

	if ( ! isset( $settings['aweber'] ) )
		$settings = wpp_premium_aweber_modify_default_settings( $settings );

	$app_id = "b6967d06";

	$auth_url = "https://auth.aweber.com/1.0/oauth/authorize_app/$app_id";

	include WPP_PREMIUM_FUNCTIONALITY_PATH . 
			'/aweber/settings_page_view.php';

}

function wpp_premium_aweber_modify_default_settings( $settings ) {

	$settings['aweber'] = array( 'auth_code' => '', 'list_id' => '' );

	return $settings;

}

function wpp_premium_aweber_email_service_select( $email_service ) {

	$selected = '';

	if ( $email_service == 'aweber' )
		$selected = 'selected="selected"';

	echo "<option value='aweber' $selected>Aweber</option>";

}

function wpp_premium_aweber_store_email( $data ) {

	$settings = wpp_get_settings();

	$subscriber_exist_message = $settings['error_message']['subscriber_already_exist'];

	$unknown_error_message = $settings['error_message']['unknown'];

	if ( ! isset( $settings['aweber'] ) )
		$settings = wpp_premium_aweber_modify_default_settings( $settings );

	$list_id = $settings['aweber']['list_id'];

	$account_id = $settings['aweber']['account_id'];

	$auth_info = get_option( 'wpp_aweber_auth_info' );

	if ( ! $auth_info ) {

		$response = array(
					'status' => 'error',
					'code' => -1,
					'aweber_exception_type' => 'auth_error',
					'aweber_doc_url' => '',
					'message' => $unknown_error_message . ' - ' . 'Invalid Authorization Token'
				);

		exit( json_encode( $response ) );

	}

	require_once WPP_PREMIUM_FUNCTIONALITY_PATH . 
				'/aweber/aweber_api/aweber_api.php';
	
	$aweber = new AWeberAPI( $auth_info['consumer_key'], $auth_info['consumer_secret'] );

	try {

		$account = $aweber->getAccount( $auth_info['access_key'], $auth_info['access_secret'] );

		$list = $account->lists->find( array( 'name' => $list_id ) );

		$list = $list[0];

		$list_url = "/accounts/{$account->id}/lists/{$list->id}";

		$list = $account->loadFromUrl( $list_url );
		
		$params = array(
	        'email' => $data['email'],
	        'ip_address' => $data['__ip_address'],
	        'misc_notes' => 'Added By WP Popup Plugin',
	        'name' => $data['name'],
	        /*'custom_fields' => array(
	            'POPUPID' => $data['popup_id'],
	            'POPUPTHEMEID' => $data['theme_id'],
	        ),*/
    	);

    	$subscribers = $list->subscribers;
    	
    	$new_subscriber = $subscribers->create($params);

	}
	catch(AweberAPIException $exc) {

		if ( $exc->message == 'email: Subscriber already subscribed.' )
			$exc->message = $subscriber_exist_message;

		$response = array(
					'status' => 'error',
					'aweber_status' => $exc->status,
					'code' => -1,
					'aweber_exception_type' => $exc->type,
					'aweber_doc_url' => $exc->documentation_url,
					'message' => $unknown_error_message . ' - ' . $exc->message
				);

		exit( json_encode( $response ) );

	}

	
	
}

function wpp_premium_aweber_save_settings() {

	$settings = wpp_get_settings();
		
	$auth_code = $_POST['settings']['aweber']['auth_code'];

	if ( $settings['aweber']['auth_code'] == $auth_code )
		return FALSE;

	try {
			require_once WPP_PREMIUM_FUNCTIONALITY_PATH . 
				'/aweber/aweber_api/aweber_api.php';
				
			$auth = AWeberAPI::getDataFromAweberID( $auth_code );

			list( $consumer_key, $consumer_secret, $access_key, $access_secret ) = $auth;

			$aweber_auth_info = array(
					'consumer_key' => $consumer_key,
					'consumer_secret' => $consumer_secret,
					'access_key' => $access_key,
					'access_secret' => $access_secret
				);

			update_option( 'wpp_aweber_auth_info', $aweber_auth_info );

		}
		catch( AweberAPIException $exc ) {



		}
}


add_action( 'wpp_settings_page_end', 'wpp_premium_aweber_settings_page' );

add_filter( 'wpp_default_options', 'wpp_premium_aweber_modify_default_settings' );

add_action( 'wpp_settings_email_service_select', 
	'wpp_premium_aweber_email_service_select' );

add_action( 'wpp_store_email_to_aweber', 
	'wpp_premium_aweber_store_email'  );

add_action( 'wpp_save_settings', 'wpp_premium_aweber_save_settings' );